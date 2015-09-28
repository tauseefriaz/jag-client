<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_data       = $this->Auth_model->check();
        $this->load->model('Parameters_model');
        $this->load->model('Bench_model');
        $this->sessionUserData = $this->Auth_model->loggedin();
    }

    public function index() {

        $data = array();
        $data['parameters'] = $this->Parameters_model->getParameters();

        $this->load->view('bench/dashboard_view', $data);
    }

}
