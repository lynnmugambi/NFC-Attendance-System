<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'main_class.php';
$m = new Main();

//This gets all the other information from the form
foreach ($_POST as $p)
    if (empty($p) || !isset($p))
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../admin.php"
        );


//This is the directory where images will be saved
$target = '../img/';
$target_file = $target . basename($_FILES['image']['name']);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_FILES['image']['name'])){
    $check = getimagesize($_FILES['image']['tmp_name']);
    if($check !== false) {
        $m->debug_to_console( "File is an image - ". $check["mime"] .".");
        $uploadOk = 1;
    } else {
        $m->debug_to_console( "File is not an image.");
        $m->phpAlert("File is not an image.","../admin.php");
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["image"]["size"] > 500000) {
    $m->debug_to_console("Sorry, your file is too large.");
    $m->phpAlert("Sorry, your file is too large.","../admin.php");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $m->debug_to_console("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $m->phpAlert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.","../admin.php");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $m->debug_to_console( "Sorry, your file was not uploaded.");
    $m->phpAlert("Sorry, your file was not uploaded.","../admin.php");
}
else {


//assign values to variables
    $name = "";
    $phone = "";

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if (verify(NAME, $name) === false) {
            $m->phpAlert("Invalid name format!", "../admin.php");
            exit();
        }
    }
    if (isset($_POST['phone'])) {
        $phone = $_POST['phone'];
        if (verify(PHONE, $phone) === false) {
            $m->phpAlert("Invalid phone format!", "../admin.php");
            exit();
        }
    }

    $pic = ($_FILES['image']['name']);
    $admin_id = $_SESSION['admin_id'];

// Connects to your Database
    $con = connectTo();

//Writes the information to the database
    $stmt = $con->prepare('Update `Admin` Set `Name` =  :offname,
                                                     `Phone` = :phone,
                                                     `Image` = :pic
                                                Where `AdminID` = :id');
    $stmt->bindValue(":offname", $name);
    $stmt->bindValue(":phone", $phone);
    $stmt->bindValue(":pic", $pic);
    $stmt->bindValue(":id", $admin_id);

    if (!$stmt) {
        echo "\nPDO::errorInfo:\n";
        print_r($con->errorInfo());
    }

    $stmt->execute();

//Writes the photo to the server
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {

//Tells you if its all ok
        $m->phpAlert('The file ' . basename($_FILES["image"]["name"]) . ' has been uploaded, and your information has been added to the directory.', "../admin.php");

    } else {

//Gives and error if its not
        $m->phpAlert("Sorry, there was a problem uploading your file.", "../admin.php");
    }
}

