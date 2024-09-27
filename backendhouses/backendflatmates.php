<?php
session_start();
ob_start();
if(isset($_SESSION['userid'])){
    echo('login status Green');
}
else{
    header("Location:../frontend_authentication/Login.php");
    exit();
}

$userid = $_SESSION['userid'];
$city = trim(strtolower($_POST['city']));
$area = trim(strtolower($_POST['area']));
$streetname = trim(strtolower($_POST['streetname']));
$roadname = trim(strtolower($_POST['roaddetail']));
$pincode = $_POST['pincode'];
$address = trim(strtolower($_POST['address']));
$rentrate = $_POST['price'];
$deposit = $_POST['deposit'];
$sqft = $_POST['sqft'];
$modeofhouse = trim(strtolower($_POST['ModeOfHouse']));
$roomtype = $_POST['RoomType'];
$allowedtenant = trim(strtolower($_POST['TenantFor']));
$furnish = trim(strtolower($_POST['furnish']));
$propertytype = trim(strtolower($_POST['propertytype']));
$allowedfood = trim(strtolower($_POST['showonly']));
$floor = $_POST['floors'];
$parkingtype = trim(strtolower($_POST['parkingStatus']));
$metro = ($_POST['metrofm']);
$bathroom = $_POST['bathroomfacility'];
$image = $_FILES['housepics'];
if (empty($_FILES['housepics']['tmp_name'])) {
    $_SESSION['databackup'] = [
        'city' => $city,
        'area' => $area,
        'streetname' => $streetname,
        'roadname' => $roadname,
        'pincode' => $pincode,
        'address' => $address,
        'rentrate' => $rentrate,
        'deposit' => $deposit,
        'sqft' => $sqft,
        'modeofhouse' => $modeofhouse,
        'roomtype' => $roomtype,
        'allowedtenant' => $allowedtenant,
        'furnish' => $furnish,
        'propertytype' => $propertytype,
        'allowedfood' => $allowedfood,
        'floor' => $floor,
        'parkingstatus' => $parkingtype,
        'metro' => $metro,
        'bathroom' => $bathroom,
    ];
    $_SESSION['errormessage'] = 'Dear User Please Upload Image';
    $_SESSION['optionpick'] = 'flathouse';
    header("Location:../php_upload/upload.php");
    exit();
}

$tempimage = $_FILES['housepics']['tmp_name'];
$imagename = $_FILES['housepics']['name'];
$imagetype=$_FILES['housepics']['type'];
$bimage = file_get_contents($tempimage);
if (isset($_POST['RoomType']) && is_array($_POST['RoomType'])) {
    $roomtype = implode(',', $_POST['RoomType']);
} else {
    $roomtype = ''; 
}

include '../database/database.php';
database::$db_name = 'poovarasi_RoomHunter';
database::connection();

$sql= database::connection()->prepare("INSERT INTO housedataflathouse(deposit, sqft, userid, city, area, streetname, roadname, pincode, address, rentrate, modeofhouse, roomtype, allowedtenant, furnish, propertytype, allowedfood, floor, parkingtype, bathroom, blobimage, mimetype,metro) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql->bind_param("iisssssisissssssssssss",$deposit, $sqft, $userid, $city, $area, $streetname, $roadname, $pincode, $address, $rentrate, $modeofhouse, $roomtype, $allowedtenant, $furnish, $propertytype, $allowedfood, $floor, $parkingtype, $bathroom, $bimage, $imagetype,$metro);
$sql->execute();
$sql->close();
header("Location:../frontend_houses/mysellhouse.php");
exit();
ob_end_clean();

?>