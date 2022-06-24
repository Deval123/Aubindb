<?php
/**
 * Created by PhpStorm.
 * User: devalere
 * Date: 28/01/2020
 * Time: 06:55
 */

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

  require "dbconnect.php";

$data = file_get_contents("php://input");
    if (isset($data)) {
        $request = json_decode($data);
        $id = $request->id;
        $nom = $request->nom;
        $sigle = $request->sigle;
        $tel = $request->tel;
        $email = $request->email;
        $ouverture = $request->ouverture;
        $fermeture = $request->fermeture;
        $garde = $request->garde;
        $description = $request->description;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $city_id = $request->city_id;
    }
//  id nom sigle tel email ouverture fermeture garde description images datecreate latitude longitude deplacePointeur pharmacists_id city_id
$sql = "UPDATE pharmacy SET nom = '$nom', sigle = '$sigle', tel = '$tel', email = '$email', ouverture = '$ouverture', 
          fermeture = '$fermeture', garde = '$garde', city_id = '$city_id', longitude = '$longitude', latitude = '$latitude',
           description = '$description' WHERE id ='$id';";


    if ($con->query($sql) === TRUE) {
        $response= "data update successfull";

    } else {
        $response= "Error: ". $sql . "<br>" ;
    }

	echo json_encode( $response);


?>
