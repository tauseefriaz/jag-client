<?php

class Auth_model extends CI_Model {

    public function __construct() {
        // model constructor
        parent::__construct();
    }

    function check() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login/?error=2', 'refresh');
        } else {
            return $this->session->userdata('logged_in');
        }
    }

    function loggedin() {
        if (!$this->session->userdata('logged_in')) {
            return NULL;
        }
        $result               = $this->session->userdata('logged_in');
        $result["name"]       = $result['name'];
        $result["user_id"]    = $result['id'];
        $result["user_email"] = $result['email'];
        return $result;
    }

}

?>