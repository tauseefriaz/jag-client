<?php

class Properties_model extends CI_Model {

    protected static $nonWhereProperties = array("dataSortBy", "dataSort", "dataLimit", "dataStart");

    public function __construct() {
        // model constructor
        parent::__construct();
    }

    function getPropOrCounts($queryData, $count = NULL) {

        foreach ($queryData as $field => $value) {
            if (!in_array($field, self::$nonWhereProperties)) {

                switch ($field) {
                    case "price":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "between")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "area":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "between")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "parking":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "between")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "area_state_id":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "in")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "area_city_id":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "in")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "area_city_id":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "in")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "area_location_id":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "in")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "area_sub_location_id":
                        if ($queryReturn = $this->getBetweenLikeInQuery($field, $value, "in")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    case "keyword":
                        if ($queryReturn = $this->getBetweenLikeInQuery(array('description', 'title'), $value, "like")) {
                            $this->db->where($queryReturn, NULL, FALSE);
                        }
                        break;
                    default:

                        if ($value[0] > 0) {
                            $this->db->where($field, $value[0]);
                        }
                        break;
                }
            }
        }

        $this->db->from(DB_PROPERTES);
        if ($count == 1) {
            $this->db->select('id', FALSE);
            return $this->db->count_all_results();
        } else {
            $this->db->select('*', FALSE);
            $this->db->limit($queryData["dataLimit"], $queryData["dataStart"]);
            $this->db->order_by($queryData["dataSortBy"], $queryData["dataSort"]);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    private function getBetweenLikeInQuery($field, $values, $type) {

        if ($type == "between"):
            $valueOne = $values[0];
            $valueTwo = $values[1];

            if ($valueOne != "" && $valueTwo != "") {
                $query = "( `$field` between '$valueOne' and '$valueTwo' )";
            } elseif ($valueOne != "" && $valueTwo == "") {
                $query = "( `$field`  >= '$valueOne' )";
            } elseif ($valueOne == "" && $valueTwo != "") {
                $query = "( `$field`  <= '$valueTwo' )";
            } else {
                $query = "";
            }
        endif;

        if ($type == "in"):
            $values = array_filter($values);
            if (!empty($values)) {
                $query = "`$field` in ( " . implode(",", $values) . " )";
            } else {
                $query = "";
            }
        endif;


        if ($type == "like"):
            if (!empty($values)) {
                $query = '(';
                if (!empty($field[0])) {
                    $query .= "`$field[0]` like '%$values[0]%'";
                }
                if (!empty($field[1])) {
                    $query .= "or `$field[1]` like '%$values[0]%'";
                }
                $query .= ')';
            } else {
                $query = "";
            }
        endif;

        return $query;
    }

    function getSingleProperty($propID) {
        $this->db->select('*');
        $this->db->where('id', $propID);
        $this->db->from(DB_PROPERTES);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getSinglePropertyPictures($propID) {
        $this->db->select('*');

        $this->db->where('property_id', $propID);

        $this->db->from(DB_IMAGES);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getSinglePropertyUser($userID) {
        $this->db->select('name,mobile_no,phone_no');

        $this->db->where('id', $userID);

        $this->db->from(DB_USERS);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getLatestProperties($fetch_by = 'dateupdated', $amount) {
        if ($amount > 30) {
            $amount = 10;
        }
        $this->db->select('*');
        $this->db->limit($amount);
        $this->db->order_by($fetch_by, 'desc');

        $this->db->from(DB_PROPERTES);
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>