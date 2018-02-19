<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'main_class.php';

$stud = "";
$class = "";

if (empty($_POST['classid']) || empty($_POST['studid'])) {
    respond("error", "empty");
} else {
    if (isset($_POST['classid'])) {
        $class = $_POST['classid'];
    }
    if (isset($_POST['studid'])) {
        $stud = $_POST['studid'];
    }
    //$_SESSION['class'] = $class;

    $m = new Main();
    $m->searchAtt($class,$stud);

}
