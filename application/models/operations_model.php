<?php

class Operations_model extends CI_Model {

    public function __construct() {
        // model constructor
        parent::__construct();
    }

    function getPhoneNumber($user_id, $property_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $property_id);
        $this->db->set('stats_phone', 'stats_phone+1', FALSE);
        $result = $this->db->update(DB_PROPERTES);

        if ($result) {
            $this->db->select('mobile_no,phone_no');
            $this->db->where('id', $user_id);
            $this->db->from(DB_USERS);
            $query = $this->db->get();
            return $query->row_array();
        }
    }

}

?>