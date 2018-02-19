<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'defines.php';

/*********** VALIDATE ALL VARIABLES ************/

$email = "";
$pass = "";

if (!isset($_POST['email']) && !isset($_POST['password'])) {
    respond("error", "empty");
}

if (isset($_POST['email'])) {
    $email = strtolower($_POST['email']);
    if (verify(EMAIL, $email) === false) respond("error", "email");
}
if (isset($_POST['password'])) {
    $pass = $_POST['password'];
}

//checking email format
/*********** SEARCH **********/
$con = connectTo();
$exists = $con->prepare("SELECT * FROM `Lecturer` WHERE `Email` = :email AND `Password` = :password");
$exists->bindValue(":email", $email);
$exists->bindValue(":password", $pass);

//debugging for SQL errors
if (!$exists) {
    echo "\nPDO::errorInfo():\n";
    print_r($con->errorInfo());
}

$exists->execute();
$rows = $exists->fetchAll();

if (count($rows) == 0) {
    $exists2 = $con->prepare("SELECT * FROM `Admin` WHERE `Email` = :email AND `Password` = :password");
    $exists2->bindValue(":email", $email);
    $exists2->bindValue(":password", $pass);

    if (!$exists2) {
        echo "\nPDO::errorInfo():\n";
        print_r($con->errorInfo());
    }

    $exists2->execute();

    $rows = $exists2->fetchAll();

    if (count($rows) == 0) {
        $con = null;
        respond("error", "not_found");
    } else {

        foreach ($rows as $row) {

            // START SESSION
            $_SESSION['email'] = $row['Email'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['type'] = $row['Type'];


            session_write_close();


            die(json_encode(array("error" => "none", "session" => $_SESSION)));
        }
    }


} else {
    foreach ($rows as $row) {

        // START SESSION
        $_SESSION['email'] = $row['Email'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['type'] = $row['Type'];


        session_write_close();


        die(json_encode(array("error" => "none", "session" => $_SESSION)));
    }
}

?>

