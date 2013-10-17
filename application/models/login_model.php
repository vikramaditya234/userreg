<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Chat happens from here
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
        // Store user record in DB
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
        $this->db->insert('userinfo', $profile);
        return $data['activationkey'];
    }

    // Creates key for forgot password mail
    function createForgotPasswordKey($email) {
    }

    // Check if the key is valid
    function isValidKey($key) {

    }

    // Reset password
    function resetPassword($data) {

    }
}