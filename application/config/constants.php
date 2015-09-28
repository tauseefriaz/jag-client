<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


define('API_SERVER_URL', 'http://tauxeef.com/jag-server');
define('ASSETS_URL', 'http://tauxeef.com/jag-client/assets/');

define('PHOTOS_ORIGINAL_PATH', 'uploads/pictures/original/');
define('PHOTOS_RESIZED_PATH', 'uploads/pictures/');
define('PHOTOS_THUMBS_PATH', 'uploads/pictures/thumbs/');

define('COUNTRY_ID', 1);
define('PROPERTY_RECORDS_PER_PAGE', 20);


/* DB Tabled */
define('DB_CITIES',                             'area_cities');
define('DB_COUNTRIES',                          'area_country');
define('DB_STATES',                             'area_states');
define('DB_LOCATIONS',                          'area_locations');
define('DB_SUB_LOCATIONS',                      'area_sub_locations');
define('DB_FEATURES',                           'features');
define('DB_PROPERTES',                          'properties');
define('DB_PROPERTY_TYPES',                     'property_types');
define('DB_TYPES',                              'types');
define('DB_SETTINGS',                           'settings');
define('DB_USERS',                              'users');
define('DB_IMAGES',                             'images');
define('DB_CONTACTS',                           'contacts');
define('DB_COMPANY',                            'company');
define('DB_USER_TYPES',                         'user_types');




/* End of file constants.php */
/* Location: ./application/config/constants.php */