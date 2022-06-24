<?php
/**
 * Created by PhpStorm.
 * User: devalere
 * Date: 03/03/2019
 * Time: 03:27
 */


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=utf-8");

require_once("conn.php");

include "config.php";
$elseif ($postjson['aksi'] == 'get_pharmacy'){
    //  id nom sigle tel email ouverture fermeture garde description images datecreate latitude longitude deplacePointeur pharmacists_id city_id
    //  id department_id nom longitude latitude
// id nom prenom sexe tel email password login images datecreate
$ps = $pdo->prepare("SELECT P.id as idpharm, P.nom as nonpharm, P.sigle , P.tel as telpharm, P.email as emailpharm, 
                    P.ouverture, P.fermeture, P.garde, P.description, P.images as imagespharm, P.images1 as images1pharm, P.images2 as images2pharm,
                    P.datecreate as datecreatepharm, 
                   P.latitude, P.longitude, P.deplacePointeur, C.id as idcity, C.department_id,
          C.nom as nomcity, C.longitude as longitudecity, C.latitude as latitudecity, A.id as idpharmacien, A.nom as nompharmacien,
          A.prenom as prenompharmacien, A.sexe, A.tel as telpharmacien, A.email as emailpharmacien, A.images as imagespharmacien, 
        A.datecreate as datecreatepharmacien 
      FROM pharmacy as P 
      LEFT JOIN city as C ON P.city_id = C.id 
      LEFT JOIN pharmacists as A ON P.pharmacists_id = A.id 
      ORDER BY C.nom ASC ;");
$ps->execute();
$liste = $ps->fetchAll(PDO::FETCH_ASSOC);
$data = array();
foreach ($liste as $i => $v) {
    $fields = array();
    foreach ($v as $key => $value) {
        $fields[$key] = utf8_encode($value);
    }
    $data[$i] = $fields;
}

if ($liste) $result = json_encode(array('success' => true, 'result' => $data));
else $result = json_encode(array('success' => false));
echo $result;


/*SELECT P.id as idpharm, P.nom as nonpharm, P.sigle , P.tel as telpharm, P.email as emailpharm,
                    P.ouverture, P.fermeture, P.garde, P.description, P.images as imagespharm, P.images1 as images1pharm, P.images2 as images2pharm,
                    P.datecreate as datecreatepharm,
                   P.latitude, P.longitude, P.deplacePointeur, P.actif, C.id as idcity, C.department_id,
          C.nom as nomcity, C.longitude as longitudecity, C.latitude as latitudecity, A.id as idpharmacien, A.nom as nompharmacien,
          A.prenom as prenompharmacien, A.sexe, A.tel as telpharmacien, A.email as emailpharmacien, A.images as imagespharmacien,
        A.datecreate as datecreatepharmacien
      FROM (SELECT * from pharmacy where actif =1) as P
      LEFT JOIN city as C ON P.city_id = C.id
      LEFT JOIN pharmacists as A ON P.pharmacists_id = A.id
      ORDER BY C.nom ASC ;*/