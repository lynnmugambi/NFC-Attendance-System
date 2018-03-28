<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'main_class.php';
$m = new Main();
/**
 * Created by PhpStorm.
 * User: Mwendwa Mugambi
 * Date: 8/27/2017
 * Time: 8:46 PM
 */
if (isset($_POST['submit'])) {
    $class_id = $_SESSION['class_id'];
    $count_t = $m->check_table($class_id);

    if ($count_t == 0) {
        $m->debug_to_console("not exists");
        foreach ($_POST["TPNo"] as $key => $value) {
            $status = $_POST["status"][$key];
            $tp_num = $_POST["TPNo"][$key];
            $m->debug_to_console($tp_num);
            $m->debug_to_console($status);
            $m->debug_to_console($_SESSION['class_id']);
            $class_id = $_SESSION['class_id'];
            $totalclass = $_SESSION['totalclass'];

            $m->save_attendance($tp_num, $status, $class_id, $totalclass);
        }
        $m->phpAlert("Records saved successfully! Redirecting you to main page...", "../class.php");
    } else {
        foreach ($_POST["TPNo"] as $key => $value) {
            $m->debug_to_console("exists");
            $status = $_POST["status"][$key];
            $tp_num = $_POST["TPNo"][$key];
            $m->debug_to_console($tp_num);
            $m->debug_to_console($status);
            $m->debug_to_console($_SESSION['class_id']);
            $class_id = $_SESSION['class_id'];

            $m->save_attendance2($tp_num, $status, $class_id);
        }
        $m->phpAlert("Records saved successfully! Redirecting you to main page...", "../class.php");
    }
}
?>