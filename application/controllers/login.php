<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Creating User login/logout, fetching user profile info, forgot password
     *
     */

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('login_model');
    }

    // Show login form and perform login
    public function index() {
        // Check if the user is already logged in
        if (($ret = $this->login_model->isUserLogin()) == TRUE) {
            // User is already logged in show the success page
            $this->load->view('login_sucess', $ret);
            return;
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Login form';
        if ($this->form_validation->run('login') === FALSE){
            $this->load->view('login');
        }
        else {
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');
            if ($this->login_model->loginUser($data) === FALSE) {
                log_message('debug', 'invalid login');
                $this->load->view('login', array('err' => 'Invalid username or password'));
            }
            else
                $this->load->view('login_sucess', $ret);
        }
    }

    // Perform user logout
    public function doLogout() {
        $this->login_model->logoutUser();
        $this->load->view('logout');
    }

    // Show signup form
    public function doSignup() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        // Validate the form
        if ($this->form_validation->run('signup') === FALSE){
            // Invalid input by the user show the signup form
            $this->load->view('signup');
        }
        else {
            $data['firstname'] = $this->input->post('firstname');
            $data['lastname'] = $this->input->post('lastname');
            $data['password'] = $this->input->post('password');
            $data['email'] = $this->input->post('email');
            // Create the user and show success page if done
            $key = $this->login_model->createUser($data);
            $this->load->helper('email');
            $account_activation_email = $this->load->view('accountactivationemail', array('key' => $key, 'names' => $data), TRUE);
            send_email($data['email'], 'New user account activation key', $account_activation_email);
            $this->load->view('signup_success');
        }
    }

    // Show forgot password form
    public function forgotPassword() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->form_validation->run('forgot_password') === FALSE){
            $this->load->view('forgotpwd');
        }
        else {
            $email = $this->input->post('email');
            if (($key = $this->login_model->createForgotPasswordKey($email)) == FALSE) {
                $this->load->view('forgotpwd', array('err', FORGOT_PASS_MAILING_ERR));
                return;
            }
            $this->load->model('profile_model');
            $this->load->helper('email');
            $user_names = $this->profile_model->get(array('firstname', 'lastname'), array('email' => $email));
            $forgot_pwd_email = $this->load->view('forgotpwdemail', array('key' => $key, 'names' => $user_name), TRUE);
            send_email($email, 'Password reset', $forgot_pwd_email);
            $this->load->view('signup', array('success' => FORGOT_PASS_LINK_SUCCESS));
        }
    }

    // Reset password form
    public function resetPassword($key = null) {
        if ($key != null) {
            // check if this is a valid key
            if ($this->login_model->isValidKey($key) == FALSE) {
                $this->load->view('reset_password', array('err' => FORGOT_PASS_INVALID_LINK_ERR));
                return;
            }
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->form_validation->run('reset_password') === FALSE){
            $this->load->view('reset_password');
        }
        else {
            $data['password'] = $this->input->post('password');
            $data['cpassword'] = $this->input->post('cpassword');
            $ret = $this->login_model->resetPassword($data);
            if ($ret == TRUE)
                $this->load->view('reset_password_success');
            else
                $this->load->view('reset_password', $ret);
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */