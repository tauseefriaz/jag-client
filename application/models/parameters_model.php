<?php

class Parameters_model extends CI_Model {

    public function __construct() {
        // model constructor
        parent::__construct();
    }

    function getPropertyTypes($parent_id) {
        $this->db->select('*');
        if ($parent_id > 0) {
            $this->db->where('parent_id', $parent_id);
        }
        $this->db->from(DB_PROPERTY_TYPES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getTypes() {
        $this->db->select('*');
        $this->db->from(DB_TYPES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getUserTypes() {
        $this->db->select('*');
        $this->db->from(DB_USER_TYPES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getCountries() {
        $this->db->select('*');
        $this->db->from(DB_COUNTRIES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getStates($country_id) {
        $this->db->select('*');
        if ($country_id > 0) {
            $this->db->where('country_id', $country_id);
        }
        $this->db->from(DB_STATES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getCities($state_id) {
        $this->db->select('*');
        if ($state_id > 0) {
            $this->db->where('state_id', $state_id);
        }
        $this->db->from(DB_CITIES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getLocations($city_id) {
        $this->db->select('*');
        if ($city_id > 0) {
            $this->db->where('city_id', $city_id);
        } else {
            $this->db->where('parent_id =', 0);
        }
        $this->db->from(DB_LOCATIONS);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getSubLocations($parent_id) {
        $this->db->select('*');
        if ($parent_id > 0) {
            $this->db->where('parent_id', $parent_id);
        } else {
            $this->db->where('parent_id !=', 0);
        }

        $this->db->from(DB_LOCATIONS);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getFeatures($parent_id) {
        $this->db->select('*');
        if ($parent_id > 0) {
            $this->db->where('parent_id', $parent_id);
        }
        $this->db->from(DB_FEATURES);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getCountrySettings($country_id) {
        $this->db->select('*');
        if ($country_id > 0) {
            $this->db->where('country_id', $country_id);
        }
        $this->db->from(DB_SETTINGS);
        $query = $this->db->get();
        return $query->result_array("id");
    }

    function getRooms() {
        $result = array(
            "bedrooms" => array(
                "0.5"       => "Studio",
                1           => "1 Bedroom",
                2           => "2 Bedrooms",
                3           => "3 Bedrooms",
                4           => "4 Bedrooms",
                5           => "5 Bedrooms",
                6           => "6+ Bedrooms"),
            "bathrooms" => array(1 => "1 Bathroom",
                2 => "2 Bathrooms",
                3 => "3 Bathrooms",
                4 => "4 Bathrooms",
                5 => "5 Bathrooms",
                6 => "6+ Bathrooms"),
        );

        return $result;
    }

    function getPriceRange() {
        //$price_type = $this->input->get('price_type');
        $result = array(
            "minPrice" => array(10000, 20000, 40000, 80000, 100000, 200000, 500000),
            "maxPrice" => array(20000, 40000, 80000, 100000, 200000, 500000, 1000000),
        );

        return $result;
    }

    function getAreaRange() {
        //$area_type = $this->input->get('area_type');
        $result = array(
            "minArea" => array(1, 2, 3, 4, 5, 10, 15, 20),
            "maxArea" => array(5, 10, 15, 20, 30, 40, 50),
        );

        return $result;
    }

    function getParameters() {
        $result['p_states']        = $this->getStates(NULL);
        $result['p_cities']        = $this->getCities(NULL);
        $result['p_locations']     = $this->getLocations(NULL);
        $result['p_sub_locations'] = $this->getSubLocations(NULL);
        $result['p_rooms']         = $this->getRooms();
        $result['p_price_range']   = $this->getPriceRange();
        $result['p_area_range']    = $this->getAreaRange();
        $result['p_main_types']    = $this->getTypes(NULL);
        $result['p_features']      = $this->getFeatures(NULL);
        $result['p_types']         = $this->getPropertyTypes(NULL);
        $result['init_settings']   = $this->getCountrySettings(COUNTRY_ID);

        return $result;
    }

}

?>