<?php

Class Bench_model extends CI_Model {

    function getListingsDatatable($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/listings/datatable', $sendData);
        return $result;
    }

    function getListingsSingleItem($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/listings/single', $sendData);
        return $result;
    }

    function submitListingsSingleitem($sendData) {
        $result = $this->rest->post(API_SERVER_URL . '/bench/listings/submit', $sendData);
        return $result;
    }

    function getListingPhotos($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/listings/get_photos', $sendData);
        return $result;
    }

    function uploadListingPhoto($sendData) {

        $config['upload_path']   = PHOTOS_ORIGINAL_PATH;
        $config['allowed_types'] = 'jpg|png|gif';
        $config['file_name']     = date('dmy') . "-" . time() . "-" . rand() . "-" . $sendData['userData']['id'];
        $config['max_size']      = '0';
        $config['max_width']     = '0';
        $config['max_height']    = '0';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('Filedata')) {
            echo $this->upload->display_errors();
        } else {
            $sendData['getData']['photoDetails'] = $this->upload->data();

            /* resize to thumb */
            $config = array(
                'source_image'    => $sendData['getData']['photoDetails']['full_path'],
                'new_image'       => PHOTOS_THUMBS_PATH,
                'maintain_ration' => true,
                'width'           => 150,
                'height'          => 100
            );

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $this->image_lib->clear();

            /* resize to web standard size */
            $config = array(
                'source_image'    => $sendData['getData']['photoDetails']['full_path'],
                'new_image'       => PHOTOS_RESIZED_PATH,
                'maintain_ration' => true,
                'width'           => 800,
                'height'          => 600
            );

            $this->image_lib->initialize($config);
            $this->image_lib->resize();


            $result = $this->rest->post(API_SERVER_URL . '/bench/listings/insert_photo', $sendData);
            return $result;
        }
    }

    /* contacts screen */

    function getContactsDatatable($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/contacts/datatable', $sendData);
        return $result;
    }

    function getContactsSingleItem($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/contacts/single', $sendData);
        return $result;
    }

    function submitContactsSingleitem($sendData) {
        $result = $this->rest->post(API_SERVER_URL . '/bench/contacts/submit', $sendData);
        return $result;
    }

    /* contacts screen end */

    /* profile screen */

    function getProfileSingleItem($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/users/profile', $sendData);
        return $result;
    }

    function submitProfileSingleitem($sendData) {
        $result = $this->rest->post(API_SERVER_URL . '/bench/users/profile_submit', $sendData);
        return $result;
    }

    /* profile screen end */
    
    
    /* users screen */

    function getUsersDatatable($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/users/datatable', $sendData);
        return $result;
    }

    function getUsersSingleItem($sendData) {
        $result = $this->rest->get(API_SERVER_URL . '/bench/users/single', $sendData);
        return $result;
    }

    function submitUsersSingleitem($sendData) {
        $result = $this->rest->post(API_SERVER_URL . '/bench/users/submit', $sendData);
        return $result;
    }

    /* users screen end */
}

?>
