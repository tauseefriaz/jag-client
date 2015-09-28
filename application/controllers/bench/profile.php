<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_data       = $this->Auth_model->check();
        $this->load->model('Parameters_model');
        $this->load->model('bench/Users_model');
        $this->sessionUserData = $this->Auth_model->loggedin();
    }

    public function index() {
        $data = array();
        $data['parameters'] = $this->Parameters_model->getParameters();
        $data['profile'] = $this->Users_model->profileModel($this->user_data);
        $this->load->view('bench/profile_view', $data);
    }
    
    public function submit() {
        $postData = $this->input->post();
        $userData = $this->user_data;
        
        $data = $this->Users_model->insertUpdateProfileModel($postData, $userData);
        echo $data;
    }

}
