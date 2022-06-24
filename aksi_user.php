<?php
/**
 * Created by PhpStorm.
 * User: devalere
 * Date: 28/01/2019
 * Time: 12:41
 */

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=utf-8");

//
require_once("conn.php");
include "config.php";
$postjson = json_decode(file_get_contents('php://input'), true);
if ($postjson['aksi'] == 'add_user') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/users/img_user" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "INSERT INTO users SET 
                nom = '$postjson[nom]',
                prenom = '$postjson[prenom]',
                sexe = '$postjson[sexe]',
                tel = '$postjson[tel]',
                email = '$postjson[email]',
                login = '$postjson[login]',
                password = '$postjson[password]',
                images  = '$directory',
                datecreate = '$datenow' 
                ");
    $idadd = mysqli_insert_id($mysqli);
    if ($query) $result = json_encode(array('success' => true, 'idadd' => $idadd));
    else $result = json_encode(array('success' => false));
    echo $result;
} elseif ($postjson['aksi'] == 'add_pharmacists') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/pharmacists/img_pharmacists" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "INSERT INTO pharmacists   SET 
                nom = '$postjson[nom]',
                prenom = '$postjson[prenom]',
                sexe = '$postjson[sexe]',
                tel = '$postjson[tel]',
                email = '$postjson[email]',
                login = '$postjson[login]',
                password = '$postjson[password]',
                images  = '$directory',
                datecreate = '$datenow' 
                ");
    $idadd = mysqli_insert_id($mysqli);
    if ($query) $result = json_encode(array('success' => true, 'idadd' => $idadd));
    else $result = json_encode(array('success' => false));
    echo $result;
} elseif ($postjson['aksi'] == 'add_pharmacy') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/pharmacy/img_pharmacy" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "INSERT INTO pharmacy   SET 
                nom = '$postjson[nom]',
                sigle = '$postjson[sigle]',
                ouverture = '$postjson[ouverture]',
                tel = '$postjson[tel]',
                email = '$postjson[email]',
                fermeture = '$postjson[fermeture]',               
                description = '$postjson[description]',
                latitude = '$postjson[latitude]',
                longitude = '$postjson[longitude]',
                city_id = '$postjson[city_id]',
                pharmacists_id = '$postjson[pharmacists_id]',
                images  = '$directory',
                datecreate = '$datenow' 
                ");
    $idadd = mysqli_insert_id($mysqli);
    if ($query) $result = json_encode(array('success' => true, 'idadd' => $idadd));
    else $result = json_encode(array('success' => false));
    echo $result;
} //// 	nom	sigle	tel	email	ouverture	fermeture	garde	description	images	datecreate	latitude	longitude	deplacePointeur	pharmacists_id

elseif ($postjson['aksi'] == 'get_user') {
    $data = array();
    $query = mysqli_query($mysqli, "SELECT * FROM users WHERE login = '$postjson[username]'  and password = '$postjson[password]'  ORDER BY id DESC");

    while ($row = mysqli_fetch_array($query)) {
        $data[] = array(
            'id' => $row['id'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'sexe' => $row['sexe'],
            'tel' => $row['tel'],
            'email' => $row['email'],
            'password' => $row['password'],
            'images' => $row['images'],
            'login' => $row['login'],
            'datecreate' => $row['datecreate']
        );
    }

    if ($query) {
        $count = mysqli_num_rows($query);

        if ($count > 0) {
            $result = json_encode(array('success' => true, 'result' => $data));
        } else {
            $result = json_encode(array('success' => false));

        }
    }
    echo $result;
} elseif ($postjson['aksi'] == 'get_pharmacists') {
    $data = array();
    $query = mysqli_query($mysqli, "SELECT * FROM pharmacists WHERE login = '$postjson[username]'  and password = '$postjson[password]'  ORDER BY id DESC");

    while ($row = mysqli_fetch_array($query)) {
        $data[] = array(
            'id' => $row['id'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'sexe' => $row['sexe'],
            'tel' => $row['tel'],
            'email' => $row['email'],
            'password' => $row['password'],
            'images' => $row['images'],
            'login' => $row['login'],
            'datecreate' => $row['datecreate']
        );
    }

    if ($query) {
        $count = mysqli_num_rows($query);

        if ($count > 0) {
            $result = json_encode(array('success' => true, 'result' => $data));
        } else {
            $result = json_encode(array('success' => false));

        }
    }
    echo $result;
} elseif ($postjson['aksi'] == 'get_city') {
    $ps = $pdo->prepare("SELECT C.id, C.nom as nomcity, C.longitude, C.latitude, D.name as nomdepartement, D.id as iddepartement,
  D.region_id, D.chef_lieu FROM city as C 
     LEFT JOIN department as D ON C.department_id = D.id ORDER BY C.nom ASC ;");
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
} elseif ($postjson['aksi'] == 'get_pharmacy') {
  //  id nom sigle tel email ouverture fermeture garde description images datecreate latitude longitude deplacePointeur pharmacists_id city_id
  //  id department_id nom longitude latitude
// id nom prenom sexe tel email password login images datecreate
    $ps = $pdo->prepare("SELECT P.id as idpharm, P.nom as nonpharm, P.sigle , P.tel as telpharm, P.email as emailpharm,
                    P.ouverture, P.fermeture, P.garde, P.description, P.images as imagespharm, P.images1 as images1pharm, P.images2 as images2pharm,
                    P.datecreate as datecreatepharm,
                   P.latitude, P.longitude, P.deplacePointeur, P.actif, C.id as idcity, C.department_id,
          C.nom as nomcity, C.longitude as longitudecity, C.latitude as latitudecity, A.id as idpharmacien, A.nom as nompharmacien,
          A.prenom as prenompharmacien, A.sexe, A.tel as telpharmacien, A.email as emailpharmacien, A.images as imagespharmacien,
        A.datecreate as datecreatepharmacien
      FROM (SELECT * from pharmacy where actif =1) as P
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
} elseif ($postjson['aksi'] == 'update_user') {
    $data = array();
    $query = mysqli_query($mysqli, "UPDATE master_user SET 
                user_name = '$postjson[user_name]',
                phone_number = '$postjson[phone_number]',
                gender = '$postjson[gender]' 
                WHERE  user_id='$postjson[user_id]'");

    if ($query) $result = json_encode(array('success' => true));
    else $result = json_encode(array('success' => false));
    echo $result;
}
elseif ($postjson['aksi'] == 'del_user') {
    $query = mysqli_query($mysqli, "DELETE FROM master_user WHERE  user_id='$postjson[user_id]'");

    if ($query) $result = json_encode(array('success' => true));
    else $result = json_encode(array('success' => false));
    echo $result;
} elseif ($postjson['aksi'] == 'get_datasingle') {
    $data = array();
    $query = mysqli_query($mysqli, "SELECT * FROM master_user WHERE user_id='$postjson[user_id]'");

    while ($row = mysqli_fetch_array($query)) {
        $data = array(
            'user_name' => '$row[user_name]',
            'phone_number' => '$row[phone_number]',
            'gender' => '$row[gender]',
            'created_at' => '$row[created_at]',
        );
    }
    if ($query) $result = json_encode(array('success' => true, 'result' => $data));
    else $result = json_encode(array('success' => false));
    echo $result;
}
elseif ($postjson['aksi'] == 'get_pharmId') {
    $ps = $pdo->prepare("SELECT * FROM pharmacy WHERE pharmacists_id='$postjson[pharmacists_id]';");
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
}
//C:/Users/devalere/Pictures/IMG-20191218-WA0024.jpg
elseif ($postjson['aksi'] == 'edit_pharmacy') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/pharmacy/img_pharmacy" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "UPDATE pharmacy SET 
                nom = '$postjson[nom]',
                sigle = '$postjson[sigle]',
                ouverture = '$postjson[ouverture]',
                tel = '$postjson[tel]',
                email = '$postjson[email]',
                fermeture = '$postjson[fermeture]',               
                description = '$postjson[description]',
                latitude = '$postjson[latitude]',
                garde = '$postjson[garde]',
                longitude = '$postjson[longitude]',
                city_id = '$postjson[city_id]',
                images  = '$directory'
                WHERE  id='$postjson[id]'");
    //  id nom sigle tel email ouverture fermeture garde description images datecreate latitude longitude deplacePointeur pharmacists_id city_id
    if ($query) $result = json_encode(array('success' => true));
    else $result = json_encode(array('success' => false));
    echo $result;
}

elseif ($postjson['aksi'] == 'edit_pic') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/pharmacy/img_pharmacy" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "UPDATE pharmacy SET 
                images  = '$directory'
                WHERE  id='$postjson[id]'");
    //  id nom sigle tel email ouverture fermeture garde description images datecreate latitude longitude deplacePointeur pharmacists_id city_id
    if ($query) $result = json_encode(array('success' => true));
    else $result = json_encode(array('success' => false));
    echo $result;
}

elseif ($postjson['aksi'] == 'edit_pic2' || $postjson['aksi'] == 'add_images1') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/pharmacy/img_pharmacy" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "UPDATE pharmacy SET 
                images1  = '$directory'
                WHERE  id='$postjson[id]'");
    if ($query) $result = json_encode(array('success' => true));
    else $result = json_encode(array('success' => false));
    echo $result;
}

elseif ($postjson['aksi'] == 'edit_pic3' || $postjson['aksi'] == 'add_images2') {
    $data = array();
    $datenow = date('y-m-d');
    $datenow1 = date('Y-m-d H-i-s');// use to remove duplicate name of  images
    $entry = base64_decode($postjson['images']);
    $img = imagecreatefromstring($entry);
    $directory = "images/pharmacy/img_pharmacy" . $datenow1 . ".jpg"; // save gambar to folder sever
    imagejpeg($img, $directory);
    imagedestroy($img);
    $query = mysqli_query($mysqli, "UPDATE pharmacy SET 
                images2  = '$directory'
                WHERE  id='$postjson[id]'");
    if ($query) $result = json_encode(array('success' => true));
    else $result = json_encode(array('success' => false));
    echo $result;
}