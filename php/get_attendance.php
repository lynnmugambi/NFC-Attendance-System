<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'defines.php';

$tpno = "";
$class_id = "";

if (empty($_POST['classID']) || empty($_POST['studID'])) {
    respond("error", "empty");
} else {
    if (isset($_POST['classID'])) {
        $class_id = $_POST['classID'];
    }
    if (isset($_POST['studID'])) {
        $tpno = $_POST['studID'];
    }
    $tname = "ClassID_" . $class_id . "_attendance";

    $con = connectTo();
    $num_tables = $con->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $tname . "'");
    $num_tables->execute();
    $tables = $num_tables->fetchAll();
    $count_t = count($tables);
    if($count_t == 0){
        respond("error", "no_class");
    }
    else {

        $stmt = $con->prepare("SELECT Classes_Had,Classes_Attended FROM `{$tname}` WHERE StudentID = :tp");

        $stmt->bindValue(":tp", $tpno);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (count($rows) == 0) {
            $con = null;
            respond("error", "not_found");
        } else {
            foreach ($rows as $row) {
                // START SESSION

                $_SESSION['had'] = $row['Classes_Had'];
                $_SESSION['att'] = $row['Classes_Attended'];
                $_SESSION['stud'] = $tpno;
                $_SESSION['class1']=$class_id;

                session_write_close();
                die(json_encode(array("error" => "none", "session" => $_SESSION)));
            }
        }
    }
}
?>
