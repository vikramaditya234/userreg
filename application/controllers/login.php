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
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Login form';
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|md5');
        if ($this->form_validation->run() === FALSE){
            $this->form_validation->set_message('email', 'Invalid email');
            $this->form_validation->set_message('password', 'Invalid password');
        }
        else {
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');
            if ($this->login_model->login_user($data) == true)
                $this->load->view('login_sucess');
            else
                $this->load->view('login', $ret);
        }
        $this->load->view('login');
    }

    // Perform user logout
    public function doLogout() {
        $this->login_model->logout_user()
        $this->load->view('logout');
    }

    // Show signup form
    public function doSignup() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Signup form';
        $this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]|min_length[8]|md5');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|trim');
        if ($this->form_validation->run() === FALSE){
            $this->form_validation->set_message('name', 'Invalid name');
            $this->form_validation->set_message('password', 'Invalid password');
            $this->form_validation->set_message('cpassword', 'Invalid confirm password');
            $this->form_validation->set_message('email', 'Invalid email');
        }
        else {
            $data['name'] = $this->input->post('name');
            $data['password'] = $this->input->post('password');
            $data['cpassword'] = $this->input->post('cpassword');
            $data['email'] = $this->input->post('email');
            if (($ret = $this->login_model->create_user($data)) == true)
                $this->load->view('signup_success');
            else
                $this->load->view('signup', $ret);
        }
        $this->load->view('signup');
    }

    // Show forgot password form
    public function forgotPassword() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Forgot password form';
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() === FALSE){
            $this->form_validation->set_message('email', 'Invalid email');
        }
        else {
            $email = $this->input->post('email');
            $ret = $this->login_model->create_user();
            if ($ret == true)
                $this->load->view('signup_success');
            else
                $this->load->view('signup', $ret);
        }
        $this->load->view('forgotpwd');
    }

    // Reset password form
    public function resetPassword() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Reset password form';
        $this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]|min_length[8]|md5');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|trim');
        if ($this->form_validation->run() === FALSE){
            $this->form_validation->set_message('password', 'Invalid password');
            $this->form_validation->set_message('cpassword', 'Invalid confirm password');
        }
        else {
            $data['password'] = $this->input->post('password');
            $data['cpassword'] = $this->input->post('cpassword');
            $ret = $this->login_model->create_user($data);
            if ($ret == true)
                $this->load->view('resetpwd_success');
            else
                $this->load->view('resetpwd', $ret);
        }
        $this->load->view('resetpwd');

    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */