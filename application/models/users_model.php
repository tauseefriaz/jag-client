<?php

Class Users_model extends CI_Model {

    function loginDetails($email, $password) {
        $this->db->select('id, email, name');
        $this->db->from(DB_USERS);
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function checkUserExistance($email) {
        $this->db->select('email');
        $this->db->from(DB_USERS);
        $this->db->where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function createAccount($name, $email, $password, $ip) {
        $data = array(
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
            'user_ip'   => $ip,
            'dateadded' => time()
        );

        return $result = $this->db->insert(DB_USERS, $data);
        $this->db->insert_id();
    }

}

?>
