<?php
include './php/main_class.php';
if (!isset($_SESSION)) {
    session_start();
}
$card = "";

if (!isset($_POST['card'])) {
    respond("error", "empty");
} else {
    $card = $_POST['card'];
    $m->debug_to_console(card);

    $con = connectTo();
    $exists2 = $con->prepare("SELECT StudentID FROM `Student` WHERE `NFC_uid` = :card");
    $exists2->bindValue(":card", $card);

    if (!$exists2) {
        echo "\nPDO::errorInfo():\n";
        print_r($con->errorInfo());
    }

    $exists2->execute();
    $rows = $exists2->fetchAll();
    //return $rows;


}

