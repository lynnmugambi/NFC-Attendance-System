<?php
if(!isset($_SESSION))
{
    session_start();
}

include 'defines.php';

/**
 *
 */
function get_Profile()
{
    $username = "";

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        respond("error", "empty");
    }

    $con = connectTo();
    $stmt = $con->prepare("SELECT * FROM Lecturer WHERE Username=?");
    if (!$stmt) {
        echo "\nPDO::errorInfo():\n";
        print_r($con->errorInfo());
    }

    $stmt->execute(array($username));

    $rows = $stmt->fetchAll();

    if (count($rows) == 0) {
        $con = null;
        respond("error", "not_found");
    }
    else {
        foreach($rows as $row) {
            // START SESSION

            $_SESSION['lec_id'] = $row['LecID'];
            $_SESSION['title'] = $row['Title'];
            $_SESSION['name'] = $row['Name'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['phone'] = $row['Phone'];
            $_SESSION['dept'] = $row['Dept'];

            $lec_id = $_SESSION['lec_id'];
            $title = $_SESSION['title'];
            $name = $_SESSION['name'];
            $email = $_SESSION['email'];
            $phone = $_SESSION['phone'];

            session_write_close();

            if (verify(EMAIL, $email) === false) respond("error", "email");
            //if (verify(PHONE, $phone) === false) respond("error", "phone");
            if (verify(NAME, $name) === false) respond("error", "name");

        }
    }
}


