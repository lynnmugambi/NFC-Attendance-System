<?php
include './main_class.php';
if (!isset($_SESSION)) {
    session_start();
}


if (!isset($_POST['studid'])) {
    respond("error", "empty");
}

else{
    $_SESSION['studid2']="";
    //unset($_SESSION['studid2']);
   $_SESSION['studid2']=$_POST['studid'];
    session_write_close();


    die(json_encode(array("error" => "none", "session" => $_SESSION)));
}
?>
