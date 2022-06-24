<?php
/**
 * Created by PhpStorm.
 * User: devalere
 * Date: 28/01/2019
 * Time: 12:56
 */




/*define('DB_HOST','localhost');
define('DB_USER', 'pharma1394_user');
define('DB_PASSWORD','Dcg85PvQr#Fy');
define('DB_NAME','pharma1394_bd');*/




define('DB_HOST','localhost');
define('DB_USER', 'root');
define('DB_PASSWORD','');
define('DB_NAME','pharmapp');
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

date_default_timezone_set('Africa/Douala');



