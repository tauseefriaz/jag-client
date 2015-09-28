<?php

class Contacts_model extends CI_Model {

    public function __construct() {
        // model constructor
        parent::__construct();
    }

    function datatableModel($getData, $userData, $repData = NULL) {

        $aColumns = array(
            'id',
            'ref',
            'first_name',
            'last_name',
            'mobile_number',
            'phone_number',
            'fax_number',
            'email',
            'nationality',
            'country',
            'city',
            'address',
            'dateadded',
            'dateupdated'
        );

        $sIndexColumn = "id";

        $sTable = 'jaP_' . DB_CONTACTS;

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

            @$row['ref']         = REF_PREFIX . "-C-" . str_pad($row['id'], 6, '0', STR_PAD_LEFT);
            @$row['dateupdated'] = @date('d/m/y H:i:s', $row['dateupdated']);
            @$row['dateadded']   = @date('d/m/y H:i:s', $row['dateadded']);

            $output['aaData'][] = $row;
        }

        return json_encode($output);
    }

    function singleModel($getData, $userData) {
        $this->db->select('*, CONCAT( "' . REF_PREFIX . '-C-", LPAD(id,6,"0") ) as ref', FALSE);
        $this->db->where('user_id', $userData['id']);
        $this->db->where('id', $getData['itemID']);
        $this->db->from(DB_CONTACTS);
        $query = $this->db->get();

        return json_encode($query->result_array('id'));
    }

    function insertUpdateModel($postData, $userData) {
        $dataSame = array(
            'first_name'    => $postData['first_name'],
            'last_name'     => $postData['last_name'],
            'mobile_number' => $postData['mobile_number'],
            'phone_number'  => $postData['phone_number'],
            'fax_number'    => $postData['fax_number'],
            'email'         => $postData['email'],
            'nationality'   => $postData['nationality'],
            'country'       => $postData['country'],
            'city'          => $postData['city'],
            'address'       => $postData['address']
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
            $result = $this->db->update(DB_CONTACTS, $data);
            return $postData['id'] . "|" . $result;
        } else {
            $data   = array_merge($dataSame, $dataInsert);
            $result = $this->db->insert(DB_CONTACTS, $data);
            return $this->db->insert_id() . "|" . $result;
        }
    }

}

?>