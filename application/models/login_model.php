<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Login, Logout, Forgot password, Activation
class Login_model extends CI_Model {

    public function __construct (){
        parent::__construct();
        $this->load->database();
    }

    // Check user input and start his session
    function loginUser ($data) {
        // SQL query to get entry for email and password from DB
        $query = $this->db->get_where('userlogin', array('email' => $data['email'], 'password' => $data['password']));
        if (($query->num_rows() > 0) && ($query->row()->email == $data['email'])) {
            // Store the user information in the SESSION
            $_SESSION['useremail'] = $data['email'];
            return true;
        }
        return false;
    }

    // Check if the user is already logged in 
    function isUserLogin() {
        if (isset($_SESSION['useremail'])) {
            unset($_SESSION['useremail']);
            return true;
        }
        return false;        
    }

    // Logout user
    function logoutUser() {
        if ($this->isUserLogin()) {
            unset($_SESSION['useremail']);
            return true;
        }
        else {
            header("Location: /");
            exit;
        }
    }

    // Create user entry in DB
    function createUser($data) {
        $this->load->model('profile_model');
        $data['activationkey'] = md5(time());
        // login type 0 means it is native login not external site dependent
        $data['logintype'] = REGULAR_USER;
        $profile['firstname'] = $data['firstname'];
        $profile['lastname'] = $data['lastname'];
        unset($data['firstname']);
        unset($data['lastname']);
        log_message('debug','create user data: '.print_r($data, true));
        // Insert login information
        $this->db->insert('userlogin', $data);
        $query = $this->db->get_where('userlogin', array('email' => $data['email']));
        $profile['userid'] = $query->row()->id;
        // Now insert profile information with name
        $this->profile_model->set($profile);
        return $data['activationkey'];
    }

    // Creates key for forgot password mail
    function createForgotPasswordKey($email) {
        $query = $this->db->get_where('userlogin', array('email' => $email));
        if ($query->num_rows() > 0) {
            // Found the user record now create entry in pwdreminder table
            $data['userid'] = $query->row()->id;
            $data['key'] = md5(time());
            $this->db->insert('pwdreminder', $data);
            return $data['key'];
        }
        return false;
    }

    // Check if there are any account pending activation with this key
    function isValidActivateKey($key) {
        $query = $this->db->get_where('userlogin', array('activationkey' => $key, 'active' => 0));
        if ($query->num_rows() > 0) {
            // Found the user for activation get his details
            $userid = $query->row()->id;
            $query = $this->db->get_where('userinfo', array('userid' => $userid));
            return array('firstname' => $query->row()->firstname, 'lastname' => $query->row()->lastname, 'userid' => $userid);
        }
        return false;
    }

    // Activate the user account
    public function activateAccount($userid) {
        $this->db->where('id', $userid);
        $this->db->update('userlogin', array('active' => 1)); 
    }

    // Check if this key is valid reset password key
    function isValidResetKey($key) {
        $query = $this->db->get_where('pwdreminder', array('key' => $key, 'used' => 0));
        if ($query->num_rows() > 0) {
            // Found the record for password reminder
            return $query->row()->userid;
        }
        return false;
    }

    // Reset password
    function resetPassword($data) {
        $this->db->where('id', $data['userid']);
        $this->db->update('userlogin', array('password' => $data['password']));

        // Mark the forgot password row in DB as used
        $this->db->where('userid', $data['userid']);
        $this->db->update('pwdreminder', array('used' => 1));
    }

    // Check if the account is active
    public function isAccountActive($email) {
        $query = $this->db->get_where('userlogin', array('email' => $email, 'active' => 1));
        return ($query->num_rows() > 0);
    }
}