<?php

/*try {
    $strConnection= 'mysql:host=localhost; dbname=pharma1394_bd';
    $pdo = new PDO ($strConnection, 'pharma1394_user', 'Dcg85PvQr#Fy');
}
catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e ->getMessage();
    die ($msg);
}*/

  try {
      $strConnection= 'mysql:host=localhost; dbname=pharmapp';
      $pdo = new PDO ($strConnection, 'root', '');
  }
  catch (PDOException $e) {
      $msg = 'ERREUR PDO dans ' . $e ->getMessage();
      die ($msg);
  }
?>