<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('getUriSlugID')) {

    function getUriSlugID($dataArray, $slug, $index) {
        if ($slug) {
            $array = array();
            foreach ($dataArray as $key => $value) {
                $array[$value[$index]][] = $value["id"];
            }
            if (empty($array[$slug])) {
                show_404();
            }
            return $array[$slug][0];
        }
    }

    function getField($table, $field, $id, $getfield) {
        $sql = "select $getfield from $table where $field='" . mysql_real_escape_string($id) . "'";
        $rs  = mysql_fetch_object(mysql_query($sql));
        if ($rs != '')
            return $rs->$getfield;
        else
            return '';
    }

}