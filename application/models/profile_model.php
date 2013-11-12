<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Access user information
class Profile_model extends CI_Model {

    public function __construct (){
        parent::__construct();
        $this->load->database();
    }

    // Get all the field items requested based on the unique
    function get($request, $unique) {
        if (isset($unique['email'])) {
            $this->db->select('*')->from('userlogin')->join('userinfo', 'userinfo.userid = userlogin.id')->where($unique);
            $query = $this->db->get();
        }
        else {
            $query = $this->db->get_where('userinfo', $unique);
        }
        $response = array();
        foreach ($request as $key => $value) {
            $response[$value] = $query->row()->$value;
        }

        return $response;
    }

    // Set values based on the unique key
    function set($values, $unique = array()) {
        if (empty($unique)) {
            $this->db->insert('userinfo', $values);
        }
        else {
            // Update the existing record
            $this->db->where($unique);
            $this->db->update('userinfo', $values);
        }
    }
}