<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "main_class.php";
$m = new Main();

$lec = "";
$class = "";
$sem = "";
$day = "";
$start = "";
$end = "";
$dura = "";


    if (isset($_POST['Lec_ID'])) {
        $lec = $_POST['Lec_ID'];
    }
    if (isset($_POST['Class_ID'])) {
        $class = $_POST['Class_ID'];
    }
    if (isset($_POST['Semester'])) {
        $sem = $_POST['Semester'];
    }
    if (isset($_POST['Day'])) {
        $day = $_POST['Day'];
    }
    if (isset($_POST['Start_Time'])) {
        $start = $_POST['Start_Time'];
    }
    if (isset($_POST['End_Time'])) {
        $end = $_POST['End_Time'];
    }
    if (isset($_POST['Duration'])) {
        $dura = $_POST['Duration'];
    }


    $m->updateAssigned($lec, $class, $sem, $day, $start, $end,$dura);

