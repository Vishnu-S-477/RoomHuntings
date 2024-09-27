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

$city = trim(strtolower($_POST['city']));
$area = trim(strtolower($_POST['area']));
$streetname = trim(strtolower($_POST['streetname']));
$roadname = trim(strtolower($_POST['roaddetail']));
$pincode = $_POST['pincode']; 
$address = trim(strtolower($_POST['address']));
$rentrate = $_POST['price'];
$deposit = $_POST['deposit'];
$sqft = $_POST['sqft'];
$modeofhouse = ($_POST['ModeOfHouse']);
$housetype = $_POST['HousingType'];
$houseavailable = $_POST['houseavailable'];
$preferredtennets = $_POST['preferredtenates'];
$propertytype = $_POST['propertytypefullhouse'];
$furnish = $_POST['furnishfullhouse'];
$parkingstatus = $_POST['parkingStatusfullhouse'];
$metro = $_POST['metrofh'];
$image = $_FILES['housepic'];
if (empty($_FILES['housepic']['name'])) {
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
        'housetype' => $housetype,
        'houseavailable' => $houseavailable,
        'preferredtenates' => $preferredtennets,
        'propertytype' => $propertytype,
        'furnish' => $furnish,
        'parkingstatus' => $parkingstatus,
        'metro' => $metro,
    ];
    $_SESSION['errormessage'] = 'Dear User Please Upload Image';
    $_SESSION['optionpick'] = 'fullhouse';
    header("Location:../php_upload/upload.php");
    exit();
}

$tempimage = $_FILES['housepic']['tmp_name'];
$imagename = $_FILES['housepic']['name'];
$imagetype=$_FILES['housepic']['type'];
$bimage = file_get_contents($tempimage);
$userid = $_SESSION['userid'];
if (isset($_POST['HousingType']) && is_array($_POST['HousingType'])) {
    $housetype = implode(',', $_POST['HousingType']);
} else {
    $housetype = ''; 
}

if (isset($_POST['preferredtenates']) && is_array($_POST['preferredtenates'])) {
    $preferredtennets = implode(',', $_POST['preferredtenates']);
} else {
    $preferredtennets = ''; 
}





include '../database/database.php';
database::$db_name = 'poovarasi_RoomHunter';
database::connection();

$sql = database::$connection->prepare("INSERT INTO housedatafullhouse(deposit, sqft, city, area, streetname, roadname, pincode, address, rentrate, modeofhouse, housetype, availability, preferredtennets, propertytype, furnish, parkingstatus, blobimage, mimetype, userid,metro) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?);");

$sql->bind_param("iissssisisssssssssss",$deposit, $sqft, $city, $area, $streetname, $roadname, $pincode, $address, $rentrate, $modeofhouse, $housetype, $houseavailable, $preferredtennets, $propertytype, $furnish, $parkingstatus, $bimage, $imagetype, $userid,$metro);
$sql->execute();

$sql->close();
header("Location:../frontend_houses/mysellhouse.php");
exit();
ob_end_clean();
?>