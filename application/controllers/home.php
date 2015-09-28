<?php

set_time_limit(10000000);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->sessionUserData = $this->Auth_model->loggedin();
        $this->load->model('Parameters_model');
        $this->load->model('Properties_model');
    }

    public function index() {
        $this->benchmark->mark('code_start');

        $data["loggedUser"]        = $this->Auth_model->loggedin();
        $data['parameters']        = $this->Parameters_model->getParameters();
        $data['latest_properties'] = $this->Properties_model->getLatestProperties('dateupdated', 10);

        $this->benchmark->mark('code_end');
        $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('home_view', $data);
    }

    /* function index() {


      $state_id     = 961;
      $html_city    = file_get_contents("http://www.zameen.com/body/common/child_locations_custom.php?js_object=1&cat_id=$state_id&target_id=1&width=160&pre=cat_id");
      preg_match('/<select .*?>(.*?)<\/select>/s', $html_city, $select_city);
      $options_city = str_replace('\"', '"', $select_city[0]);

      preg_match_all('@<option value="(.*?)">(.*?)<\/option>@si', $options_city, $city_details);




      $count_city = 0;
      foreach ($city_details[1] as $city_id) {

      if ($city_id > 0) {



      $html_loc = file_get_contents("http://www.zameen.com/body/common/child_locations_custom.php?js_object=1&cat_id=$city_id&target_id=2&width=160&pre=cat_id");

      preg_match('/<select .*?>(.*?)<\/select>/s', $html_loc, $select_loc);
      preg_match_all('@latitude:\'(.*?)\', longitude:\'(.*?)\',@si', $html_loc, $lat_lon_loc);

      $data = array(
      'name'     => $city_details[2][$count_city],
      'slug'     => strtolower(str_replace(" ", "-", $city_details[2][$count_city])),
      'state_id' => 7,
      'lat'      => $lat_lon_loc[1][0],
      'lon'      => $lat_lon_loc[2][0]
      );

      $result     = $this->db->insert("jaP_area_cities", $data);
      $city_id_db = $this->db->insert_id();



      if (!empty($select_loc[0])) {
      $options_loc = str_replace('\"', '"', $select_loc[0]);

      preg_match_all('@<option value="(.*?)">(.*?)<\/option>@si', $options_loc, $loc_details);



      $count_loc = 0;
      foreach ($loc_details[1] as $loc_id) {

      if ($loc_id > 0) {


      $html_subloc = file_get_contents("http://www.zameen.com/body/common/child_locations_custom.php?js_object=1&cat_id=$loc_id&target_id=2&width=160&pre=cat_id");
      preg_match('/<select .*?>(.*?)<\/select>/s', $html_subloc, $select_subloc);
      preg_match_all('@latitude:\'(.*?)\', longitude:\'(.*?)\',@si', $html_subloc, $lat_lon_subloc);

      $data = array(
      'name'     => $loc_details[2][$count_loc],
      'slug'     => strtolower(str_replace(" ", "-", $loc_details[2][$count_loc])),
      'state_id' => 7,
      'city_id'  => $city_id_db,
      'lat'      => $lat_lon_subloc[1][0],
      'lon'      => $lat_lon_subloc[2][0]
      );

      $this->db->insert("jaP_area_locations", $data);
      $loc_id_db = $this->db->insert_id();

      if (!empty($select_subloc[0])) {
      $options_subloc = str_replace('\"', '"', $select_subloc[0]);

      preg_match_all('@<option value="(.*?)">(.*?)<\/option>@si', $options_subloc, $subloc_details);

      $count_subloc = 0;
      foreach ($subloc_details[1] as $subloc_id) {

      if ($subloc_id > 0) {
      $html_subloc_coor = file_get_contents("http://www.zameen.com/body/common/child_locations_custom.php?js_object=1&cat_id=$subloc_id&target_id=2&width=160&pre=cat_id");
      preg_match_all('@latitude:\'(.*?)\', longitude:\'(.*?)\',@si', $html_subloc_coor, $lat_lon_subloc_coor);

      $data = array(
      'name'      => $subloc_details[2][$count_subloc],
      'slug'      => strtolower(str_replace(" ", "-", $subloc_details[2][$count_subloc])),
      'parent_id' => $loc_id_db,
      'state_id'  => 7,
      'city_id'   => $city_id_db,
      'lat'       => $lat_lon_subloc_coor[1][0],
      'lon'       => $lat_lon_subloc_coor[2][0]
      );

      $this->db->insert("jaP_area_locations", $data);
      }
      $count_subloc++;
      }
      }
      }
      $count_loc++;
      }
      }
      }

      $count_city++;
      }
      }
     */
}
