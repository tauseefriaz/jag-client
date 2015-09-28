<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

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

        $this->load->view('bench/users_view', $data);
    }

    public function datatable() {
        $getData  = $this->input->get();
        $userData = $this->user_data;

        $data = $this->Users_model->datatableModel($getData, $userData);
        echo $data;
    }

    public function single() {
        $getData  = $this->input->get();
        $userData = $this->user_data;

        $data = $this->Users_model->singleModel($getData, $userData);
        echo $data;
    }

    public function submit() {
        $postData = $this->input->post();
        $userData = $this->user_data;

        $data = $this->Users_model->insertUpdateModel($postData, $userData);
        echo $data;
    }

    /* profile data */
    
    function profile_get() {
        if (!$this->input->get()) {
            $this->response(NULL, 400);
        }
        $incomingData = $this->input->get();
        $getData      = $incomingData['getData'];
        $userData     = $incomingData['userData'];

        $result = $this->Users_model->profileModel($getData, $userData);
        $this->returnResponse($result);
    }

    function profile_submit_post() {
        if (!$this->input->post()) {
            $this->response(NULL, 400);
        }
        $incomingData = $this->input->post();
        $getData      = $incomingData['getData'];
        $userData     = $incomingData['userData'];

        $result = $this->Users_model->insertUpdateProfileModel($getData, $userData);
        $this->returnResponse($result);
    }

}
