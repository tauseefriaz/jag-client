<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contacts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_data       = $this->Auth_model->check();
        $this->load->model('Parameters_model');
        $this->load->model('bench/Contacts_model');
        $this->sessionUserData = $this->Auth_model->loggedin();
    }

    public function index() {
        $data = array();
        $data['parameters'] = $this->Parameters_model->getParameters();
        $this->load->view('bench/contacts_view', $data);
    }

    public function datatable() {
        $getData  = $this->input->get();
        $userData = $this->user_data;

        $data = $this->Contacts_model->datatableModel($getData, $userData);
        echo $data;
    }

    public function single() {
        $getData  = $this->input->get();
        $userData = $this->user_data;

        $data = $this->Contacts_model->singleModel($getData, $userData);
        echo $data;
    }

    public function submit() {
        $postData = $this->input->post();
        $userData = $this->user_data;

        $data = $this->Contacts_model->insertUpdateModel($postData, $userData);
        echo $data;
    }

}
