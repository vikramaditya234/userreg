<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Form validation rules

$config = array(
            'login' => array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim|valid_email'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|md5'
                ),
            ),
            'signup' => array(
                array(
                    'field' => 'firstname',
                    'label' => 'First name',
                    'rules' => 'required|trim|xss_clean'
                ),
                array(
                    'field' => 'lastname',
                    'label' => 'Last name',
                    'rules' => 'required|trim|xss_clean'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim|valid_email|is_unique[userlogin.email]'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|matches[passconf]|md5'
                ),
                array(
                    'field' => 'passconf',
                    'label' => 'Confirm Password',
                    'rules' => 'required|trim|md5'
                ),
            ),
            'forgot_password' => array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim|valid_email'
                ),
            ),                 
            'reset_password' => array(
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|matches[passconf]|min_length[8]|md5'
                ),
                array(
                    'field' => 'passconf',
                    'label' => 'Confirm Password',
                    'rules' => 'required|trim'
                ),
            ),
        );
?>