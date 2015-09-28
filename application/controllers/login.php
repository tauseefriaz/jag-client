<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('users_model', '', TRUE);
        $this->load->model('Parameters_model');
        $this->load->library('form_validation');

        $this->sessionUserData = $this->Auth_model->loggedin();
    }

    function index() {
        $data['parameters'] = $this->Parameters_model->getParameters();
        $this->load->helper(array('form'));
        if(empty($this->sessionUserData)){
            $this->load->view('login_view', $data);
        }else{
            redirect('bench/dashboard/');
        }
        
    }

    function create_account() {

        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_user_existance');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('verify-password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors('<div class="error">', '</div>');
        } else {
            $name     = $this->input->post('name');
            $email    = $this->input->post('email');
            $password = $this->input->post('password');
            $ip       = $_SERVER['REMOTE_ADDR'];
            $result   = $this->users_model->createAccount($name, $email, $password, $ip);
            if ($result) {
                $this->check_user_and_login($password, $email);
                echo "success";
            } else {
                echo "Some thing went wrong!";
            }
        }
    }

    function check_user_existance() {
        $email = $this->input->post('email');

        $result = $this->users_model->checkUserExistance($email);
        if ($result) {
            $this->form_validation->set_message('check_user_existance', 'User with same email address already registered!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function verify() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_user_and_login');

        if ($this->form_validation->run() == FALSE) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                echo "Invalid email or password";
            } else {
                redirect('login/?error=1');
            }
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                echo "success";
            } else {
                redirect('bench/dashboard/');
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('index.php');
    }

    function check_user_and_login($password, $email = null) {
        if ($email == null) {
            $email = $this->input->post('email');
        }

        $result = $this->users_model->loginDetails($email, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id'    => $row["id"],
                    'name'  => $row["name"],
                    'email' => $row["email"],
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return FALsE;
        }
    }

}

?>
