<?php

class Listings_model extends CI_Model {

    public function __construct() {
        // model constructor
        parent::__construct();
    }

    function datatableModel($getData, $userData, $repData = NULL) {

        $aColumns = array(
            'id',
            'ref',
            'status',
            'main_type_id',
            'type_id',
            'sub_type_id',
            'area_state_id',
            'area_city_id',
            'area_location_id',
            'area_sub_location_id',
            'unit_no',
            'plot_no',
            'price',
            'area',
            'beds',
            'baths',
            'parking',
            'dateadded',
            'dateupdated'
        );

        $sIndexColumn = "id";

        $sTable = 'jaP_' . DB_PROPERTES;

        $sLimit = "";
        if (isset($getData['iDisplayStart']) && $getData['iDisplayLength'] != '-1' && is_numeric($getData['iDisplayStart']) && is_numeric($getData['iDisplayLength'])) {
            $sLimit = "LIMIT " . mysql_real_escape_string($getData['iDisplayStart']) . ", " .
                    mysql_real_escape_string($getData['iDisplayLength']);
        }

        $sOrder = "";
        if (isset($getData['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($getData['iSortingCols']); $i++) {
                if (($getData['bSortable_' . intval($getData['iSortCol_' . $i])] == "true") && ( ($getData['sSortDir_' . $i] == 'asc') || ($getData['sSortDir_' . $i] == 'desc') )) {
                    $sOrder .= $aColumns[intval($getData['iSortCol_' . $i])] . "
				 	" . mysql_real_escape_string($getData['sSortDir_' . $i]) . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }


        $sWhere = "";
        if ($getData['sSearch'] != "") {
            $aWords = preg_split('/\s+/', $getData['sSearch']);
            $sWhere = "WHERE (";

            for ($j = 0; $j < count($aWords); $j++) {
                if ($aWords[$j] != "") {
                    $sWhere .= "(";
                    for ($i = 0; $i < count($aColumns); $i++) {
                        $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($aWords[$j]) . "%' OR ";
                    }
                    $sWhere = substr_replace($sWhere, "", -3);
                    $sWhere .= ") AND ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -4);
            $sWhere .= ')';
        }

        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($getData['bSearchable_' . $i]) && $getData['bSearchable_' . $i] == "true" && $getData['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($getData['sSearch_' . $i]) . "%' ";
            }
        }

        if ($sWhere == '') {
            $sWhere .= " WHERE user_id = '" . mysql_real_escape_string($userData['id']) . "'";
        } else {
            $sWhere .= " AND user_id = '" . mysql_real_escape_string($userData['id']) . "'";
        }


        $sQuery = "
			SELECT SQL_CALC_FOUND_ROWS id, " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
		";

        $rResult = mysql_query($sQuery) or die(mysql_error());

        $sQuery             = "
			SELECT FOUND_ROWS()
		";
        $rResultFilterTotal = mysql_query($sQuery) or die(mysql_error());
        $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal     = $aResultFilterTotal[0];

        $sQuery       = "
		SELECT COUNT(" . $sIndexColumn . ")
		FROM   $sTable $sWhere
		";
        $rResultTotal = mysql_query($sQuery) or die(mysql_error());
        $aResultTotal = mysql_fetch_array($rResultTotal);
        $iTotal       = $aResultTotal[0];

        $output = array(
            "sEcho"                => intval($getData['sEcho']),
            "iTotalRecords"        => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData"               => array()
        );

        while ($aRow = mysql_fetch_array($rResult)) {
            $row = array();

            // Add the row ID and class to the object
            $row['DT_RowClass'] = 'listing_rows';
            $row['DT_RowId']    = '' . $aRow['id'];

            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "version") {
                    $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
                } else if ($aColumns[$i] != ' ') {
                    if ($aRow[$aColumns[$i]]) {
                        $row[$aColumns[$i]] = $aRow[$aColumns[$i]];
                    } else {
                        $row[$aColumns[$i]] = "- -";
                    }
                }
            }

            if ($row['status'] == 1) {
                $row['status'] = "Published";
            } elseif ($row['status'] == 2) {
                $row['status'] = "Unpublished";
            }

            is_numeric($row['main_type_id']) ? $row['main_type_id']         = $repData['p_main_types'][$row['main_type_id']]['name'] : '';
            is_numeric($row['type_id']) ? $row['type_id']              = $repData['p_types'][$row['type_id']]['name'] : '';
            is_numeric($row['sub_type_id']) ? $row['sub_type_id']          = $repData['p_types'][$row['sub_type_id']]['name'] : '';
            is_numeric($row['area_state_id']) ? $row['area_state_id']        = $repData['p_states'][$row['area_state_id']]['name'] : '';
            is_numeric($row['area_city_id']) ? $row['area_city_id']         = $repData['p_cities'][$row['area_city_id']]['name'] : '';
            is_numeric($row['area_location_id']) ? $row['area_location_id']     = $repData['p_locations'][$row['area_location_id']]['name'] : '';
            is_numeric($row['area_sub_location_id']) ? $row['area_sub_location_id'] = $repData['p_sub_locations'][$row['area_sub_location_id']]['name'] : '';

            @$row['ref']         = REF_PREFIX . "-P-" . str_pad($row['id'], 6, '0', STR_PAD_LEFT);
            @$row['price']       = number_format($row['price']);
            @$row['dateupdated'] = date('d/m/y H:i:s', $row['dateupdated']);
            @$row['dateadded']   = date('d/m/y H:i:s', $row['dateadded']);


            $output['aaData'][] = $row;
        }

        return json_encode($output);
    }

    function singleModel($getData, $userData) {
        $this->db->select('*, CONCAT( "' . REF_PREFIX . '-P-", LPAD(id,6,"0") ) as ref', FALSE);
        $this->db->where('user_id', $userData['id']);
        $this->db->where('id', $getData['itemID']);
        $this->db->from(DB_PROPERTES);
        $query = $this->db->get();

        return json_encode($query->result_array('id'));
    }

    function insertUpdateModel($postData, $userData) {
        $dataSame = array(
            'price'                => $postData['price'],
            'title'                => $postData['title'],
            'main_type_id'         => $postData['main_type_id'],
            'area'                 => $postData['area'],
            'description'          => $postData['description'],
            'sub_type_id'          => $postData['sub_type_id'],
            'type_id'              => $postData['type_id'],
            'beds'                 => $postData['beds'],
            'photos'               => $postData['photos'],
            'baths'                => $postData['baths'],
            'area_state_id'        => $postData['area_state_id'],
            'area_city_id'         => $postData['area_city_id'],
            'parking'              => $postData['parking'],
            'area_location_id'     => $postData['area_location_id'],
            'unit_no'              => $postData['unit_no'],
            'plot_no'              => $postData['plot_no'],
            'features'             => @implode(',', $postData['features']),
            'area_sub_location_id' => $postData['area_sub_location_id'],
            'status'               => $postData['status'],
        );

        $dataInsert = array(
            'user_id'     => $userData['id'],
            'dateupdated' => time(),
            'dateadded'   => time()
        );

        $dataUpdate = array(
            'dateupdated' => time()
        );

        if ($postData['id'] > 0) {
            $data   = array_merge($dataSame, $dataUpdate);
            $this->db->where('id', $postData['id']);
            $this->db->where('user_id', $userData['id']);
            $result = $this->db->update(DB_PROPERTES, $data);
            return $postData['id'] . "|" . $result;
        } else {
            $data   = array_merge($dataSame, $dataInsert);
            $result = $this->db->insert(DB_PROPERTES, $data);
            return $this->db->insert_id() . "|" . $result;
        }
    }

    function uploadPhotoModel($getData, $userData) {
        $config['upload_path']   = PHOTOS_ORIGINAL_PATH;
        $config['allowed_types'] = 'jpg|png|gif';
        $config['file_name']     = date('dmy') . "-" . time() . "-" . rand() . "-" . $userData['id'];
        $config['max_size']      = '0';
        $config['max_width']     = '0';
        $config['max_height']    = '0';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('Filedata')) {
            echo $this->upload->display_errors();
        } else {
            $getData['photoDetails'] = $this->upload->data();

            /* resize to thumb */
            $config = array(
                'source_image'    => $getData['photoDetails']['full_path'],
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
                'source_image'    => $getData['photoDetails']['full_path'],
                'new_image'       => PHOTOS_RESIZED_PATH,
                'maintain_ration' => true,
                'width'           => 800,
                'height'          => 600
            );

            $this->image_lib->initialize($config);
            $this->image_lib->resize();


            $data = array(
                'property_id' => $getData['property_id'],
                'user_id'     => $userData['id'],
                'filename'    => $getData['photoDetails']['file_name'],
                'dateadded'   => time()
            );

            $result              = $this->db->insert(DB_IMAGES, $data);
            $last_inserted_photo = $this->db->insert_id();

            /* get total photos */
            $this->db->select('id');
            $this->db->where('property_id', $getData['property_id']);
            $this->db->from(DB_IMAGES);
            $imagesCount = $this->db->count_all_results();
            /* get total photos end */

            if ($imagesCount == 1) {
                $data = array(
                    'photo_main' => $getData['photoDetails']['file_name'],
                );
                $this->db->where('id', $getData['property_id']);
                $this->db->where('user_id', $userData['id']);
                $this->db->update(DB_PROPERTES, $data);
            }

            return $last_inserted_photo . "|" . $result . "|" . $imagesCount;
        }
    }

    function getPhotosModel($propertyID, $userData) {
        $this->db->select('*');
        $this->db->where('user_id', $userData['id']);
        $this->db->where('property_id', $propertyID);
        $this->db->from(DB_IMAGES);
        $query = $this->db->get();

        return $query->result_array('id');
    }

}

?>