<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'main_class.php';

$stud = "";
$card = "";

if (empty($_POST['Stud_ID']) || empty($_POST['Card_ID'])) {
    respond("error", "empty");
} else {
    if (isset($_POST['Stud_ID'])) {
        $stud = $_POST['Stud_ID'];
    }
    if (isset($_POST['Card_ID'])) {
        $card = $_POST['Card_ID'];
    }

    $m = new Main();
    $m->assignCard($card,$stud);

}
