<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "main_class.php";
$m = new Main();
$lec = "";
$class = "";
$att= "";

if (isset($_POST['Lec_ID'])) {
    $lec = $_POST['Lec_ID'];
}
if (isset($_POST['Class_ID'])) {
    $class = $_POST['Class_ID'];
}
if (isset($_POST['Attended'])) {
    $att = $_POST['Attended'];
}
$m->updateAtt($lec,$class,$att);