<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "main_class.php";
$m = new Main();


//This gets all the other information from the form

if (isset($_POST['update_desc'])) {
    $desc = "";
    $classid = "";

    if (empty($_POST['desc'])){
        $m->phpAlert("Description field is empty! Please fill in accordingly!", "../class.php");
    }
    if (isset($_POST['desc'])) {
        $desc = $_POST['desc'];
        $m->debug_to_console($desc);
    }
    if (isset($_POST['classid'])) {
        $classid = $_POST['classid'];
        $m->debug_to_console($classid);
    }

    $m->updateDesc($classid, $desc);
}

if (isset($_POST['save_lec'])) {

    $name = "";
    $dept = "";
    $email = "";
    $id = "";
    $uname = "";
    $pass = "";

    if (empty($_POST['name']) || empty($_POST['dept']) || empty($_POST['email']) || empty($_POST['uname'])|| empty($_POST['pass'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../lec_tools.php");
    } else {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if (verify(NAME, $name) === false) {
                $m->phpAlert("Invalid name format!", "../lec_tools.php");
                exit();
            }
        }
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        if (isset($_POST['dept'])) {
            $dept = $_POST['dept'];
            if (verify(TEXT, $dept) === false) {
                $m->phpAlert("Invalid text format on Department field!", "../lec_tools.php");
                exit();
            }
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $m->debug_to_console($email);
            if (verify(EMAIL, $email) === false) {
                $m->phpAlert("Invalid E-Mail format!", "../lec_tools.php");
                exit();
            }
        }
        if (isset($_POST['uname'])) {
            $uname = $_POST['uname'];
        }
        if (isset($_POST['pass'])) {
            $pass = $_POST['pass'];
        }

        $m->debug_to_console("all set");

        $m->updateLec($id, $name, $dept, $email,$uname, $pass);
        $m->phpAlert("updated successfully!", "../lec_tools.php");
    }
}

if (isset($_POST['save_stud'])) {

    $name = "";
    $phone = "";
    $email = "";
    $course = "";
    $sem = "";
    $id = "";

    if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['course'])|| empty($_POST['sem'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../stud_tools.php");
    } else {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if (verify(NAME, $name) === false) {
                $m->phpAlert("Invalid name format!", "../stud_tools.php");
                exit();
            }
        }
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        if (isset($_POST['course'])) {
            $course = $_POST['course'];
            if (verify(TEXT, $course) === false) {
                $m->phpAlert("Invalid text format on Course field!", "../stud_tools.php");
                exit();
            }
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $m->debug_to_console($email);
            if (verify(EMAIL, $email) === false) {
                $m->phpAlert("Invalid E-Mail format!", "../stud_tools.php");
                exit();
            }
        }
        if (isset($_POST['phone'])) {
            $phone = $_POST['phone'];
            $m->debug_to_console($phone);
            if (verify(PHONE, $phone) === false) {
                $m->phpAlert("Invalid Phone Number format!", "../stud_tools.php");
                exit();
            }
        }
        if (isset($_POST['sem'])) {
            $sem = $_POST['sem'];
            $m->debug_to_console($sem);
            if (verify(SEM, $sem) === false) {
                $m->phpAlert("Invalid Semester format!", "../stud_tools.php");
                exit();
            }
        }

        $m->debug_to_console("all set");

        $m->updateStud($id, $name, $sem, $email,$course, $phone);
        $m->phpAlert("updated successfully!", "../stud_tools.php");
    }
}

if (isset($_POST['save_class'])) {

    $name = "";
    $t_class = "";
    $t_hrs = "";
    $course = "";
    $id="";

    if (empty($_POST['name']) || empty($_POST['class']) || empty($_POST['hrs']) || empty($_POST['course'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../class_tools.php");
    } else {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if (verify(NAME, $name) === false) {
                $m->phpAlert("Invalid name format!", "../class_tools.php");
                exit();
            }
        }
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        if (isset($_POST['course'])) {
            $course = $_POST['course'];
            if (verify(NUMBER, $course) === false) {
                $m->phpAlert("Invalid no. format on Course ID field!", "../class_tools.php");
                exit();
            }
        }
        if (isset($_POST['class'])) {
            $t_class = $_POST['class'];
            if (verify(NUMBER, $t_class) === false) {
                $m->phpAlert("Invalid number format on Total Classes field!", "../class_tools.php");
                exit();
            }
        }
        if (isset($_POST['hrs'])) {
        $t_hrs = $_POST['hrs'];
        if (verify(NUMBER, $t_hrs) === false) {
            $m->phpAlert("Invalid number format on Total Hours field!", "../class_tools.php");
            exit();
        }
    }


        $m->debug_to_console("status : all set");

        $m->updateClass($id, $name, $t_hrs,$course, $t_class);
        $m->phpAlert("updated successfully!", "../class_tools.php");
    }
}

if (isset($_POST['Yes'])) {
    $m->deleteLec($_POST['id']);
    $m->phpAlert("Record Deleted Successfully!","../lec_tools.php");
}
if (isset($_POST['No'])) {
    $m->phpAlert("Action Cancelled!","../lec_tools.php");
}

if (isset($_POST['Yes2'])) {
    $m->deleteStud($_POST['id']);
    $m->phpAlert("Record Deleted Successfully!","../stud_tools.php");
}
if (isset($_POST['No2'])) {
    $m->phpAlert("Action Cancelled!","../stud_tools.php");
}

if (isset($_POST['Yes3'])) {
    $m->deleteClass($_POST['id']);
    $m->phpAlert("Record Deleted Successfully!","../class_tools.php");
}
if (isset($_POST['No3'])) {
    $m->phpAlert("Action Cancelled!","../class_tools.php");
}

if (isset($_POST['Yes4'])) {
    $m->deleteCourse($_POST['id2']);
    $m->phpAlert("Record Deleted Successfully!","../class_tools.php");
}
if (isset($_POST['No4'])) {
    $m->phpAlert("Action Cancelled!","../class_tools.php");
}

if (isset($_POST['Yes5'])) {
    $m->deleteCtoC($_POST['id3']);
    $m->phpAlert("Record Deleted Successfully!","../class_tools.php");
}
if (isset($_POST['No5'])) {
    $m->phpAlert("Action Cancelled!","../class_tools.php");
}