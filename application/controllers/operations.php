<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->sessionUserData = $this->Auth_model->loggedin();
        $this->load->model('Operations_model');
    }

    public function get_phone_numberx() {
        $my_img      = imagecreate(100, 17);
        $background  = imagecolorallocate($my_img, 255, 255, 255);
        $text_colour = imagecolorallocate($my_img, 0, 0, 0);
        imagestring($my_img, 30, 0, 0, "03147077007", $text_colour);

        header("Content-type: image/png");
        imagepng($my_img);
        imagecolordeallocate($line_color);
        imagecolordeallocate($text_color);
        imagecolordeallocate($background);
        imagedestroy($my_img);
    }

    public function get_phone_number() {
        $user_id     = $this->input->post('user_id');
        $property_id = $this->input->post('property_id');
        if ($user_id > 0 and $property_id > 0) {
            $result = $this->Operations_model->getPhoneNumber($user_id, $property_id);
        }
        echo $result['mobile_no'];
    }

    public function send_enquiry_email() {
        var_dump($_POST);
    }

}
