
<?php

/* define('HOST','localhost');
define('USER', 'pharma1394_user');
define('PASS','Dcg85PvQr#Fy');
define('DB','pharma1394_bd');
$con = mysqli_connect(HOST,USER,PASS,DB);
  if (!$con){
	 die("Error in connection" . mysqli_connect_error()) ;
  }*/


define('HOST','localhost');
define('USER', 'root');
define('PASS','');
define('DB','pharmapp');
$con = mysqli_connect(HOST,USER,PASS,DB);

if (!$con){
die("Error in connection" . mysqli_connect_error()) ;
}

?>
