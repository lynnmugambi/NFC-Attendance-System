<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "main_class.php";
$m = new Main();


//This gets all the other information from the form

if (isset($_POST['add_lec'])) {

    if (empty($_POST['title']) || empty($_POST['name'])
        || empty($_POST['email']) || empty ($_POST['username']) || empty($_POST['password'])
    ){
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../lec_tools.php");
    }
    else {
        $dept = "";
        $name = "";
        $title = "";
        $email = "";
        $username = "";
        $pass = "";

        if (isset($_POST['dept'])) {
            $dept = $_POST['dept'];
            $m->debug_to_console($dept);
            if (verify(TEXT, $dept) === false) {
                $m->phpAlert("Invalid text format on Department field!", "../lec_tools.php");
                exit();
            }
        }

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $m->debug_to_console($name);
            if (verify(NAME, $name) === false) {
                $m->phpAlert("Invalid name format!", "../lec_tools.php");
                exit();
            }
        }

        if (isset($_POST['title'])) {
            $title = $_POST['title'];
            $m->debug_to_console($title);
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $m->debug_to_console($email);
            if (verify(EMAIL, $email) === false) {
                $m->phpAlert("Invalid E-Mail format!", "../lec_tools.php");
                exit();
            }
        }

        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $m->debug_to_console($username);
        }

        if (isset($_POST['password'])) {
            $pass = $_POST['password'];
            $m->debug_to_console($pass);
        }
        $type = 1;

        $m->addLec($dept, $name, $email, $title, $username, $pass, $type);
    }
}

if (isset($_POST['add_stud'])) {

    if (empty($_POST['name']) || empty($_POST['course']) ||
        empty($_POST['email']) || empty ($_POST['phone'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../stud_tools.php");
    } else {
        $course = "";
        $name = "";
        $phone = "";
        $email = "";


        if (isset($_POST['course'])) {
            $course = $_POST['course'];
            $m->debug_to_console($course);
            if (verify(TEXT, $course) === false) {
                $m->phpAlert("Invalid text format on Course field!", "../stud_tools.php");
                exit();
            }
        }

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $m->debug_to_console($name);
            if (verify(NAME, $name) === false) {
                $m->phpAlert("Invalid name format!", "../stud_tools.php");
                exit();
            }
        }

        if (isset($_POST['phone'])) {
            $phone = $_POST['phone'];
            $m->debug_to_console($phone);
            if (verify(PHONE, $phone) === false) {
                $m->phpAlert("Invalid phone format!", "../stud_tools.php");
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

        $m->addStud($name, $email, $phone, $course);
    }
}

if (isset($_POST['add_class'])) {

    if (empty($_POST['name']) || empty($_POST['cid']) ||
        empty($_POST['classes']) || empty ($_POST['hrs'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../class_tools.php");
    } else {
        $cid = "";
        $name = "";
        $hrs = "";
        $class = "";


        if (isset($_POST['cid'])) {
            $cid = $_POST['cid'];
            $m->debug_to_console($cid);
            if (verify(NUMBER, $cid) === false) {
                $m->phpAlert("Invalid format at Course ID field!", "../class_tools.php");
                exit();
            }
        }

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $m->debug_to_console($name);
            if (verify(NAME, $name) === false) {
                $m->phpAlert("Invalid name format!", "../class_tools.php");
                exit();
            }
        }

        if (isset($_POST['hrs'])) {
            $hrs = $_POST['hrs'];
            $m->debug_to_console($hrs);
            if (verify(NUMBER, $hrs) === false) {
                $m->phpAlert("Invalid format at Hours field!", "../class_tools.php");
                exit();
            }
        }

        if (isset($_POST['classes'])) {
            $class = $_POST['classes'];
            $m->debug_to_console($class);
            if (verify(NUMBER, $class) === false) {
                $m->phpAlert("Invalid format at Total Classes field!", "../class_tools.php");
                exit();
            }
        }

        $m->addClass($name, $hrs, $cid, $class);
    }
}

if (isset($_POST['add_course'])) {

    if (empty($_POST['name']) || empty($_POST['dept'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../class_tools.php");
    } else {
        $dept = "";
        $name = "";


        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $m->debug_to_console($name);
            if (verify(TEXT, $name) === false) {
                $m->phpAlert("Invalid name format!", "../class_tools.php");
                exit();
            }
        }
        if (isset($_POST['dept'])) {
        $dept = $_POST['dept'];
        $m->debug_to_console($dept);
        if (verify(TEXT, $dept) === false) {
            $m->phpAlert("Invalid Department format!", "../class_tools.php");
            exit();
        }
    }


        $m->addCourse($name, $dept);
    }
}

if (isset($_POST['add_c2c'])) {

    if (empty($_POST['classid']) || empty($_POST['course'])) {
        $m->phpAlert("One of the fields is empty! Please fill in accordingly!", "../class_tools.php");
    } else {
        $class = "";
        $course = "";


        if (isset($_POST['classid'])) {
            $class = $_POST['classid'];
            $m->debug_to_console($class);
            if (verify(NUMBER, $class) === false) {
                $m->phpAlert("Invalid Class ID format!", "../class_tools.php");
                exit();
            }
        }
        if (isset($_POST['course'])) {
            $course = $_POST['course'];
            $m->debug_to_console($course);
            if (verify(NUMBER, $course) === false) {
                $m->phpAlert("Invalid Course ID format!", "../class_tools.php");
                exit();
            }
        }


        $m->addC2C($class, $course);
    }
}