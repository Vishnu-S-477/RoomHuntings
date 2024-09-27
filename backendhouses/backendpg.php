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

$userid =$_SESSION['userid'];
$city = trim(strtolower($_POST['city']));
$area = trim(strtolower($_POST['area']));
$streetname = trim(strtolower($_POST['streetname']));
$furnish = trim(strtolower($_POST['furnishpg']));
$roadname = trim(strtolower($_POST['roaddetail']));
$pincode = $_POST['pincode'];
$address = trim(strtolower($_POST['address']));
$rentrate = $_POST['price'];
$deposit = $_POST['deposit'];
$sqft = $_POST['sqft'];
$pgfor = trim(strtolower($_POST['pgfor']));
$modeofhouse = trim(strtolower($_POST['ModeOfHouse']));
$preferredpg = $_POST['Preferredforpg'];
$parking = trim(strtolower($_POST['parkingStatuspg']));
$bathroomfacility = $_POST['bathroomfacilitypg'];
$metro = strtolower($_POST['metropg']);
$image = $_FILES['housepicpg'];
$pgroomtype = $_POST['roomtypes'];
$foodpg = $_POST['Foodincluded'];

if (empty($_FILES['housepicpg']['tmp_name'])) {
    $_SESSION['databackup'] = [
        'city' => $city,
        'area' => $area,
        'streetname' => $streetname,
        'furnish' => $furnish,
        'roadname' => $roadname,
        'pincode' => $pincode,
        'address' => $address,
        'rentrate' => $rentrate,
        'deposit' => $deposit,
        'sqft' => $sqft,
        'preferredtenates' => $pgfor,
        'preferpg' => $preferredpg,
        'modeofhouse' => $modeofhouse,
        'foodpg' => $foodpg,
        'parkingstatus' => $parking,
        'bathroom' => $bathroomfacility,
        'metro' => $metro,
        'pgroomtype' => $pgroomtype
    ];
    $_SESSION['errormessage'] = 'Dear User Please Upload Image';
    $_SESSION['optionpick'] = 'pg';
    header("Location:../php_upload/upload.php");
    exit();
}

$tempimage = $_FILES['housepicpg']['tmp_name'];
$imagename = $_FILES['housepicpg']['name'];
$imagetype=$_FILES['housepicpg']['type'];
$bimage = file_get_contents($tempimage);


if (isset($_POST['roomtypes'])) {
    $roomtype = implode(',', $_POST['roomtypes']);
} else {
    $roomtype = ''; 
}

if (isset($_POST['Preferredfor'])) {
    $preferredfor = implode(',', $_POST['Preferredfor']);
} else {
    $preferredfor = ''; 
}

if (isset($_POST['Foodincluded'])) {
    $foodfacility = implode(',', $_POST['Foodincluded']);
} else {
    $foodfacility = ''; 
}







include '../database/database.php';
database::$db_name = 'poovarasi_RoomHunter';
database::connection();

$sql= database::connection()->prepare("INSERT INTO housedatapg(deposit, sqft, userid, city, area, streetname, roadname, pincode, address, rentrate, pgfor, roomtype, preferredfor, foodfacility, bathroomfacility, blobimage, mimetype,furnish,parking,metro,modeofhouse) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"  );
$sql->bind_param("iisssssisisssssssssss",$deposit, $sqft, $userid, $city, $area, $streetname, $roadname, $pincode, $address, $rentrate, $pgfor, $roomtype, $preferredfor, $foodfacility, $bathroomfacility, $bimage, $imagetype,$furnish,$parking,$metro,$modeofhouse);
$sql->execute();
$sql->close();
header("Location:../frontend_houses/mysellhouse.php");
exit();
ob_end_clean();
?>