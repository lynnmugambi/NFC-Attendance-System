<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'main_class.php';

$class = "";
$lec = "";

if (empty($_POST['classid']) || empty($_POST['lecid'])) {
    respond("error", "empty");
} else {
    if (isset($_POST['classid'])) {
        $class = $_POST['classid'];
    }
    if (isset($_POST['lecid'])) {
        $lec = $_POST['lecid'];
    }
    $_SESSION['class'] = $class;

    $m = new Main();
    $m->searchClass($class,$lec);

    }
