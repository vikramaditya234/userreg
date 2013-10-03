<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FacebookLogin extends CI_Controller {

    /**
     * Facebook login
     *
     */
    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('facebooklogin_model');
    }

    public function connect_facebook() {
        // Check if the user has already connected his facebook account
        if ($this->facebooklogin_model->is_facebook_linked()) {
            // User account is already linked there is some problem if we are here
            log_message('error', 'User account is linked with facebook still we are trying to link him');
            redirect('/user');
        }
        $error = $this->input->get('error');
        if ($error == 'access_denied') {
            log_message('error', 'User rejected facebook connect');
            redirect('/user');
        }
        $ret = $this->facebooklogin_model->got_user();
        if ($ret == 'FACEBOOK') {
            // User doesnt have facebook account registered with us to redirect to facebook
            redirect($this->facebook->getLoginUrl(array('scope' => FACEBOOK_PERMISSION, 'redirect_uri' => FACEBOOK_RETURN_URL)));
        }
        else if ($ret == 'ERROR')
            return false;
        else
            redirect('/user');
    }
    
    // Disconnect facebook login for the user
    public function disconnect_facebook() {
        $this->facebooklogin_model->deleteFBConnection();
        redirect('/user');
    }
}