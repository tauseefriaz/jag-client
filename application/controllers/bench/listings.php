<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class listings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_data       = $this->Auth_model->check();
        $this->load->model('Parameters_model');
        $this->load->model('bench/Listings_model');
        $this->sessionUserData = $this->Auth_model->loggedin();
    }

    public function index() {
        $data = array();
        $data['parameters'] = $this->Parameters_model->getParameters();

        $this->load->view('bench/listings_view', $data);
    }

    public function datatable() {
        $getData  = $this->input->get();
        $userData = $this->user_data;
        $repData  = $this->Parameters_model->getParameters();

        $data = $this->Listings_model->datatableModel($getData, $userData, $repData);
        echo $data;
    }

    public function single() {
        $getData  = $this->input->get();
        $userData = $this->user_data;

        $data = $this->Listings_model->singleModel($getData, $userData);
        echo $data;
    }

    public function submit() {
        $postData = $this->input->post();
        $userData = $this->user_data;

        $data = $this->Listings_model->insertUpdateModel($postData, $userData);
        echo $data;
    }

    public function upload_photo() {
        $getData  = $this->input->post();
        $userData = $this->user_data;
        
        $data = $this->Listings_model->uploadPhotoModel($getData, $userData);
        echo $data;
    }

    public function get_photos($propertyID) {
        $propertyID  = $this->uri->segment(4);
        $userData = $this->user_data;
        
        $data = $this->Listings_model->getPhotosModel($propertyID, $userData);

        $html = "";
        $html .= "<div>";
        foreach ($data as $image):
            $html .= "<img height='80' width='100' src='" . base_url() . PHOTOS_RESIZED_PATH . $image["filename"] . "'>";
        endforeach;
        $html .= "</div>";

        echo $html;
    }

}
