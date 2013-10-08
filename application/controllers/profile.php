<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

    /**
     * Creating and editing User profile
     *
     */
    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('profile_model');
    }

    // Show user edit profile page
    public function index() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Profile form';
        // Date of format dd-MMM-YYYY
        $this->form_validation->set_rules('dob', 'Date of birth', 'validate_date');
        $this->form_validation->set_rules('picture', 'Profile picture', 'required|trim|md5');
        if ($this->form_validation->run() === FALSE){
            $this->form_validation->set_message('dob', 'Invalid date');
            $this->form_validation->set_message('picture', 'Invalid picture format');
        }
        else {
            $data['dob'] = $this->input->post('dob');
            $data['picture'] = $this->input->post('picture');
            if ($ret = ($this->profile_model->save_profile($data)) == true)
                $this->load->view('profile');
            else
                $this->load->view('profile', $ret);
        }
        $this->load->view('profile');
    }
}