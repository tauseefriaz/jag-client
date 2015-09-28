<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Properties extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Properties_model');
        $this->load->library('pagination');

        $this->sessionUserData = $this->Auth_model->loggedin();
    }

    public function index($type = NULL, $prop_type = NULL, $sub_prop_type = NULL, $state = NULL, $city = NULL, $location = NULL, $sub_location = NULL) {
        $this->benchmark->mark('code_start');
        $queryPara = array();
        $data = array();

        $funcPara = array(
            "type"          => $type,
            "prop_type"     => $prop_type,
            "sub_prop_type" => $sub_prop_type,
            "state"         => $state,
            "city"          => $city,
            "location"      => $location,
            "sub_location"  => $sub_location
        );

        $data["AJAX_REQUEST"] = FALSE;
        $data["AJAX_REQUEST"] = $this->input->is_ajax_request('HTTP_X_PJAX');

        $data['parameters'] = $this->Parameters_model->getParameters();

        if ($this->uri->segment(1) != 'search-results'):
            $queryPara["area_state_id"][]        = getUriSlugID($data['parameters']['p_states'], $funcPara["state"], 'slug');
            $queryPara["area_city_id"][]         = getUriSlugID($data['parameters']['p_cities'], $funcPara["city"], 'slug');
            $queryPara["area_location_id"][]     = getUriSlugID($data['parameters']['p_locations'], $funcPara["location"], 'slug');
            $queryPara["area_sub_location_id"][] = getUriSlugID($data['parameters']['p_sub_locations'], $funcPara["sub_location"], 'slug');
            $queryPara["main_type_id"][]         = getUriSlugID($data['parameters']['p_main_types'], $funcPara["type"], 'slug');
            $queryPara["type_id"][]              = getUriSlugID($data['parameters']['p_types'], $funcPara["prop_type"], 'slug');
            $queryPara["sub_type_id"][]          = getUriSlugID($data['parameters']['p_types'], $funcPara["sub_prop_type"], 'slug');

            if ($data["AJAX_REQUEST"]==FALSE) :
                $data["mTagsAndCats"] = $this->generateCategoriesAndTages($funcPara, $queryPara, $data['parameters']);
                $data["breadcrumb"]   = $this->generateBreadcrumb($queryPara, $data['parameters']);

                $data['SiteTitle']       = $data["mTagsAndCats"]['mTags']['title'];
                $data['SiteDescription'] = $data["mTagsAndCats"]['mTags']['description'];
            endif;

        else:
            $queryPara = $this->getDBFields($this->input->get());
        endif;



        $data["selectedData"] = $queryPara;

        $queryPara["dataLimit"]  = PROPERTY_RECORDS_PER_PAGE;
        $queryPara["dataStart"]  = 1;
        $queryPara["dataSortBy"] = 'dateadded';
        $queryPara["dataSort"]   = 'asc';

        $data["properties"] = $this->get_properties($queryPara);
        $this->load->view('properties_view', $data);

        $this->benchmark->mark('code_end');
        $this->benchmark->elapsed_time('code_start', 'code_end');
    }

    private function get_properties($queryData) {

        $pageNo = $this->input->get('page');
        if ($pageNo <= 1) {
            $pageNo = 0;
        } else {
            $pageNo--;
        }

        $queryData["dataStart"] = $queryData["dataLimit"] * $pageNo;
        $result['listings']     = $this->Properties_model->getPropOrCounts($queryData);

        if (!empty($result['listings'])) {
            $result['listingsCount']   = $this->Properties_model->getPropOrCounts($queryData, 1);
            $result['listingsCounts']  = "Results " . ($pageNo * PROPERTY_RECORDS_PER_PAGE) . " - " . (($pageNo + 1) * PROPERTY_RECORDS_PER_PAGE) . " of " . $result['listingsCount'];
            $result['pagination_data'] = $this->getPagination($result['listingsCount'], $queryData["dataLimit"], 7, $this->uri->uri_string(), $pageNo);
        }
        return $result;
    }

    private function getPagination($totalRows, $limit, $showLinks, $URL, $currentPage) {
        $config["base_url"] = site_url($URL) . "/";
        if (empty($totalRows)) {
            $totalRows = 0;
        }

        $config['total_rows']           = $totalRows;
        $config['per_page']             = $limit;
        $config['use_page_numbers']     = TRUE;
        $config['num_links']            = $showLinks;
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = "page";
        $config['uri_protocol']         = 'PATH_INFO';
        $config['enable_query_strings'] = TRUE;
        $config['last_tag_open']        = "";
        $config['first_tag_close']      = "";
        $config['cur_tag_open']         = '<span class="active_page" >';
        $config['cur_tag_close']        = '</span>';

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    private function getDBFields($GetDATA) {
        $result = array();
        if (empty($GetDATA)) {
            return "";
        }
        $dbFieldsList = array(
            "states"            => "area_state_id",
            "cities"            => "area_city_id",
            "locations"         => "area_location_id",
            "sub_locations"     => "area_sub_location_id",
            "type"              => "main_type_id",
            "property_type"     => "type_id",
            "property_sub_type" => "sub_type_id",
            "min_parking"       => 'parking',
            "max_parking"       => 'parking',
            "min_area"          => 'area',
            "max_area"          => 'area',
            "min_price"         => 'price',
            "max_price"         => 'price',
            "min_baths"         => 'baths',
            "max_baths"         => 'baths',
            "min_beds"          => 'beds',
            "max_beds"          => 'beds',
            "keyword"           => "keyword",
        );
        foreach ($GetDATA as $key => $values) {
            if (@in_array($dbFieldsList[$key], $dbFieldsList)) {
                if (is_array($values)) {
                    foreach ($values as $value) {
                        $result[$dbFieldsList[$key]][] = $value;
                    }
                } else {
                    $result[$dbFieldsList[$key]][] = $values;
                }
            }
        }

        return $result;
    }

    private function generateCategoriesAndTages($funcPara, $queryPara, $parameters) {
        $links = $mTags = array();
        if ($queryPara['area_sub_location_id'][0]) {
            return false;
        } elseif ($queryPara['area_location_id'][0]) {

            foreach ($parameters['p_sub_locations'] as $dataChunk) {
                if ($dataChunk["parent_id"] == $queryPara['area_location_id'][0]) {
                    $links[$dataChunk["id"]]['link'] = base_url(
                            $funcPara['type'] .
                            "/" . $funcPara['prop_type'] .
                            "/" . $funcPara['sub_prop_type'] .
                            "/" . $funcPara['state'] .
                            "/" . $funcPara["city"] .
                            "/" . $funcPara["location"] .
                            "/" . $dataChunk["slug"]
                    );
                    $links[$dataChunk["id"]]['name'] = $dataChunk["name"];
                }
            }

            $prop_type     = ucwords($funcPara['sub_prop_type']);
            $sub_prop_type = ucwords($funcPara['prop_type']);
            $type          = $funcPara['type'];
            $location      = ucwords(str_replace('-', ' ', $funcPara["location"]));
            $city          = ucwords(str_replace('-', ' ', $funcPara["city"]));

            $mTags['title']       = "{$prop_type}s for {$type} in {$location}, {$city}";
            $mTags['description'] = "Find all types of {$sub_prop_type} {$prop_type}s for {$type} in {$location}, {$city}";
        } elseif ($queryPara['area_city_id'][0]) {

            foreach ($parameters['p_locations'] as $dataChunk) {
                if ($dataChunk["city_id"] == $queryPara['area_city_id'][0]) {
                    $links[$dataChunk["id"]]['link'] = base_url(
                            $funcPara['type'] .
                            "/" . $funcPara['prop_type'] .
                            "/" . $funcPara['sub_prop_type'] .
                            "/" . $funcPara['state'] .
                            "/" . $funcPara["city"] .
                            "/" . $dataChunk["slug"]
                    );
                    $links[$dataChunk["id"]]['name'] = $dataChunk["name"];
                }
            }

            $prop_type     = ucwords($funcPara['sub_prop_type']);
            $sub_prop_type = ucwords($funcPara['prop_type']);
            $type          = $funcPara['type'];
            $city          = ucwords(str_replace('-', ' ', $funcPara["city"]));

            $mTags['title']       = "{$prop_type}s for {$type} in {$city}";
            $mTags['description'] = "Find all types of {$sub_prop_type} {$prop_type}s for {$type} in {$city}";
        } elseif ($queryPara['area_state_id'][0]) {

            foreach ($parameters['p_cities'] as $dataChunk) {
                if ($dataChunk["state_id"] == $queryPara['area_state_id'][0]) {
                    $links[$dataChunk["id"]]['link'] = base_url(
                            $funcPara['type'] .
                            "/" . $funcPara['prop_type'] .
                            "/" . $funcPara['sub_prop_type'] .
                            "/" . $funcPara['state'] .
                            "/" . $dataChunk["slug"]
                    );
                    $links[$dataChunk["id"]]['name'] = $dataChunk["name"];
                    $links[$dataChunk["id"]]['glow'] = $dataChunk["glow"];
                }
            }

            $prop_type     = ucwords($funcPara['sub_prop_type']);
            $sub_prop_type = ucwords($funcPara['prop_type']);
            $type          = $funcPara['type'];
            $state         = ucwords(str_replace('-', ' ', $funcPara["state"]));

            $mTags['title']       = "{$prop_type}s for {$type} in {$state}";
            $mTags['description'] = "Find all types of {$sub_prop_type} {$prop_type}s for {$type} in {$state}";
        } elseif ($queryPara['sub_type_id'][0]) {

            foreach ($parameters['p_states'] as $dataChunk) {
                if ($dataChunk["country_id"] == 1) {
                    $links[$dataChunk["id"]]['link'] = base_url(
                            $funcPara['type'] .
                            "/" . $funcPara['prop_type'] .
                            "/" . $funcPara['sub_prop_type'] .
                            "/" . $dataChunk["slug"]
                    );
                    $links[$dataChunk["id"]]['name'] = $dataChunk["name"];
                }
            }

            $prop_type     = ucwords($funcPara['sub_prop_type']);
            $sub_prop_type = ucwords($funcPara['prop_type']);
            $type          = $funcPara['type'];

            $mTags['title']       = "{$prop_type}s for {$type}";
            $mTags['description'] = "Find all types of {$sub_prop_type} {$prop_type}s for {$type}";
        } elseif ($queryPara['type_id'][0]) {

            foreach ($parameters['p_types'] as $dataChunk) {
                if ($dataChunk["parent_id"] == $queryPara['type_id'][0]) {
                    $links[$dataChunk["id"]]['link'] = base_url(
                            $funcPara['type'] .
                            "/" . $funcPara['prop_type'] .
                            "/" . $dataChunk["slug"]
                    );
                    $links[$dataChunk["id"]]['name'] = $dataChunk["name"];
                }
            }

            $prop_type     = ucwords($funcPara['sub_prop_type']);
            $sub_prop_type = ucwords($funcPara['prop_type']);
            $type          = $funcPara['type'];

            $mTags['title']       = "{$sub_prop_type} property for {$type} in Pakistan";
            $mTags['description'] = "Find all types of {$sub_prop_type} properties for {$type} in Pakistan";
        } elseif ($queryPara['main_type_id'][0]) {

            foreach ($parameters['p_types'] as $dataChunk) {
                if ($dataChunk["parent_id"] == 0) {
                    $links[$dataChunk["id"]]['link'] = base_url(
                            $funcPara['type'] .
                            "/" . $dataChunk["slug"]
                    );
                    $links[$dataChunk["id"]]['name'] = $dataChunk["name"];
                }
            }

            $type = $funcPara['type'];

            $mTags['title']       = "Property for {$type} in Pakistan";
            $mTags['description'] = "Find all types of properties for {$type} in Pakistan";
        }

        $result['mTags'] = $mTags;
        $result['links'] = $links;

        return $result;
    }

    private function generateBreadcrumb($queryPara, $parameters) {

        if ($queryPara['main_type_id'][0]) {
            $main_type_id     = $queryPara['main_type_id'][0];
            $links[1]['link'] = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug']
            );
            $links[1]['name'] = $parameters['p_main_types'][$main_type_id]['name'];
        }

        if ($queryPara['type_id'][0]) {
            $type_id          = $queryPara['type_id'][0];
            $links[2]['link'] = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug'] .
                    "/" . $parameters['p_types'][$type_id]['slug']
            );
            $links[2]['name'] = $parameters['p_types'][$type_id]['name'];
        }

        if ($queryPara['sub_type_id'][0]) {
            $sub_type_id      = $queryPara['sub_type_id'][0];
            $links[3]['link'] = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug'] .
                    "/" . $parameters['p_types'][$type_id]['slug'] .
                    "/" . $parameters['p_types'][$sub_type_id]['slug']
            );
            $links[3]['name'] = $parameters['p_types'][$sub_type_id]['name'];
        }

        if ($queryPara['area_state_id'][0]) {
            $area_state_id    = $queryPara['area_state_id'][0];
            $links[4]['link'] = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug'] .
                    "/" . $parameters['p_types'][$type_id]['slug'] .
                    "/" . $parameters['p_types'][$sub_type_id]['slug'] .
                    "/" . $parameters['p_states'][$area_state_id]['slug']
            );
            $links[4]['name'] = $parameters['p_states'][$area_state_id]['name'];
        }

        if ($queryPara['area_city_id'][0]) {
            $area_city_id     = $queryPara['area_city_id'][0];
            $links[5]['link'] = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug'] .
                    "/" . $parameters['p_types'][$type_id]['slug'] .
                    "/" . $parameters['p_types'][$sub_type_id]['slug'] .
                    "/" . $parameters['p_states'][$area_state_id]['slug'] .
                    "/" . $parameters['p_cities'][$area_city_id]['slug']
            );
            $links[5]['name'] = $parameters['p_cities'][$area_city_id]['name'];
        }

        if ($queryPara['area_location_id'][0]) {
            $area_location_id = $queryPara['area_location_id'][0];
            $links[6]['link'] = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug'] .
                    "/" . $parameters['p_types'][$type_id]['slug'] .
                    "/" . $parameters['p_types'][$sub_type_id]['slug'] .
                    "/" . $parameters['p_states'][$area_state_id]['slug'] .
                    "/" . $parameters['p_cities'][$area_city_id]['slug'] .
                    "/" . $parameters['p_locations'][$area_location_id]['slug']
            );
            $links[6]['name'] = $parameters['p_locations'][$area_location_id]['name'];
        }

        if ($queryPara['area_sub_location_id'][0]) {
            $area_sub_location_id = $queryPara['area_sub_location_id'][0];
            $links[7]['link']     = base_url(
                    $parameters['p_main_types'][$main_type_id]['slug'] .
                    "/" . $parameters['p_types'][$type_id]['slug'] .
                    "/" . $parameters['p_types'][$sub_type_id]['slug'] .
                    "/" . $parameters['p_states'][$area_state_id]['slug'] .
                    "/" . $parameters['p_cities'][$area_city_id]['slug'] .
                    "/" . $parameters['p_locations'][$area_location_id]['slug'] .
                    "/" . $parameters['p_sub_locations'][$area_sub_location_id]['slug']
            );
            $links[7]['name']     = $parameters['p_sub_locations'][$area_sub_location_id]['name'];
        }

        return $links;
    }

    //single property


    public function single($propID = NULL) {

        $data['parameters'] = $this->Parameters_model->getParameters();

        if ($propID > 0) {
            $property = $this->Properties_model->getSingleProperty($propID);
        }

        if (empty($property)) {
            show_404();
        }

        $data["property"] = $property;
        $data["pictures"] = $this->Properties_model->getSinglePropertyPictures($propID);
        $data["userdata"] = $this->Properties_model->getSinglePropertyUser($property[0]['user_id']);

        $queryPara['area_state_id'][0]        = $data["property"][0]['area_state_id'];
        $queryPara['area_city_id'][0]         = $data["property"][0]['area_city_id'];
        $queryPara['area_location_id'][0]     = $data["property"][0]['area_location_id'];
        $queryPara['area_sub_location_id'][0] = $data["property"][0]['area_sub_location_id'];
        $queryPara['main_type_id'][0]         = $data["property"][0]['main_type_id'];
        $queryPara['type_id'][0]              = $data["property"][0]['type_id'];
        $queryPara['sub_type_id'][0]          = $data["property"][0]['sub_type_id'];

        $data["breadcrumb"] = $this->generateBreadcrumb($queryPara, $data['parameters']);

        $this->load->view('property_details', $data);
    }

}
