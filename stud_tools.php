<?php
session_start();
$isIndex = 0;
if (!($_SESSION['type']) == 0 || !isset($_SESSION['type'])) {
    session_destroy();
    header('Location: logout.php');
    if (!$isIndex) header('Location: index.php');
}
include './php/main_class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin's Dashboard</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/admin.js"></script>

    <!--Angular JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular-route.min.js"></script>


    <script>$(document).ready(function () {
            if (!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            } else {
                //$('.selectpicker').selectpicker();
                var appletTag;
                var loop = 0;

                hideApplet(); // replace applet with clickable image

                function hideApplet() {
                    var appletbox = document.getElementById('connect');
                    appletTag = appletbox.innerHTML;

                    appletbox.innerHTML = '<button class="btn btn-primary">Connect to Reader</button>';
                }

                var ready = false;

                $("#connect").click(function () {
                    showApplet();


                    function showApplet() {
                        var appletbox = document.getElementById('connect');
                        appletbox.innerHTML = '<button class="btn btn-success">Connected!</button>';
                        startRead(true);
                    }

                    ready = true;
                });

                var timer;
                var timer2;
                var test = "testing"

                function startRead(repeat) {
                    var uidfound = "not found"
                    if (repeat === true && loop < 2) {

                        if (ready === true) {

                            var uid = document.getElementById("NFC_Applet");
                            console.log("starting");
                            uidfound = uid.getUID().getRV();
                            var card = uidfound;
                            console.log(card);

                            loop = loop + 1;
                            console.log(loop);
                            console.log(ready);

                        }

                        timer = setTimeout(function () {
                            console.log("next");
                            startRead(true);
                        }, 3000);
                    }
                    else {
                        clearTimeout(timer);
                        clearTimeout(timer2);
                        console.log('stopped');
                        ready = false;
                        return;
                    }
                }


                $("#disconnect").click(function (e) {
                    e.preventDefault();
                    ready = false;
                    startRead(false);
                });

                $('#stud_table tr').click(function () {
                    const num = $(this).find("input").attr("value");
                    if (num) {
                        window.location.href = "stud_tools.php?num=" + num;
                    }
                });
                $('#details').click(function (ev) {
                    var check = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the table below!");
                        return false;
                    } else {
                        $('.bt-example-modal-lg').modal();
                    }
                });
                $('#assign').click(function (ev) {
                    var check = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the table below!");
                        return false;
                    } else {
                        $('.ba-example-modal-lg').modal();
                    }
                });
                $('#delete').click(function (ev) {
                    var check = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the table below!");
                        return false;
                    }
                    else {
                        $('.bd-example-modal-lg').modal();
                    }
                });
                $('#attend').click(function (ev) {
                    var check = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the table below!");
                        return false;
                    }
                    else {
                        $('.be-example-modal-lg').modal();
                    }
                });
            }
        });

    </script>

</head>


<body>
<div id="header" class="clearfix">
    <div style="display: inline-block; float: left">
        <img src="img/apu.png">
    </div>
    <div style="display: inline-block; margin-left: 30px;">
        <h1>Student Attendance System</h1>
        <h2>Administrator's Dashboard</h2>
    </div>
</div>
<nav class="navbar navbar-default" id="sub-menu">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left">
            <li><a href="admin.php">Home</a></li>
            <li><a href="lec_tools.php">Lecturer Tools</a></li>
            <li class="active"><a href="stud_tools.php">Student Tools</a></li>
            <li><a href="class_tools.php">Class Tools</a></li>
            <li><a href="stats_admin.php">View Attendance</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container panel panel-default">
    <div class="panel-heading top" style="height: 250px;">
        <div>
            <?php
            echo '<h1>Welcome , ' . $_SESSION['username'] . '</h1>';
            echo '<div class="row rowx"><div class="first"><h2 >You may add a new user by : </h2></div>
                   <div class="second">
                   <button class="btn btn-success" style="margin-left: 20px;" data-toggle="modal" data-target=".bs-example-modal-lg">Add New User</button> </div></div>';
            echo '<div class="row rowx"><div class="first"><h2>Or, for existing users : </h2> </div>
                    <div class="second">
                    <button class="btn btn-primary" style="margin-left: 20px;" id="details">Edit Student Details</button>
                    <button class="btn btn-primary" style="margin-left: 20px;" id="assign">Assign Card</button>
                    <button class="btn btn-primary" style="margin-left: 20px;" id="attend">Edit Attendance</button>
                    <button class="btn btn-warning" style="margin-left: 20px;" id="delete">Delete User</button>
                    </div></div>'

            ?>
        </div>
    </div>


    <div class="panel-footer studenttable">
        <table class="table table-bordered table-hover" id="stud_table">
            <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Semester</th>
                <th>NFC Card No.</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $m = new Main();
            $rows = $m->getStud();
            $m->debug_to_console(count($rows));

            foreach ($rows as $row) {
                echo '<tr>
        <input type="hidden" value="' . $row['StudentID'] . '">
        <td >' . $row['StudentID'] . '</td>
        <td >' . $row['Name'] . '</td>
        <td >' . $row['Course'] . '</td>
        <td >' . $row['Email'] . '</td>
        <td >' . $row['Phone'] . '</td>
        <td>' . $row['Semester'] . '</td>
        <td>' . $row['NFC_uid'] . '</td>
      
      </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="non_center">
            <h2 class="text-center"> Add New User </h2>
            <hr>
            <div>
                <form class="large_modal" action="php/add_user.php" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Name: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="Name" type="name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Course: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="Course" name="course">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Email: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="Email Address" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Phone: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="E.g. 01********" name="phone">
                        </div>
                    </div>
                    <button class="btn btn-primary" id="add_lec" name="add_stud">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bt-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
>
    <div class="modal-dialog modal-lg" id="edit_lec">
        <div class="modal-content" id="non_center">
            <h2 class="text-center"> Edit Student Details </h2>
            <hr>
            <div>
                <?php
                $name = "";
                $sem = "";
                $email = "";
                $phone = "";
                $course = "";

                if (isset($_GET['num'])) {
                    $id = $_GET['num'];
                    $rows = $m->getStud_Det($id);
                    $m->debug_to_console(count($rows));

                    foreach ($rows as $row) {
                        $name = $row['Name'];
                        $sem = $row['Semester'];
                        $email = $row['Email'];
                        $phone = $row['Phone'];
                        $course = $row['Course'];

                    }

                }
                $_SESSION['id'] = $id;

                echo '
                <form class="form-horizontal large_modal" action="php/update_desc.php" method="post">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Student ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control-static"  value="' . $id . '" name="id" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Name: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="Name"  name="name" value="' . $name . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Phone: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  name="phone" value="' . $phone . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="email" value="' . $email . '">
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-sm-2"> Course: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="course" value="' . $course . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">  Semester: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="sem" value="' . $sem . '">
                        </div>
                    </div>
                    
                    <button class="btn btn-primary" id="add_lec" name="save_stud">Save Changes</button>
                </form>
            </div>
        </div>';
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
>
    <div class="modal-dialog modal-lg" id="edit_lec">
        <div class="modal-content">
            <h2 class="text-center"> Delete Record </h2>
            <hr>
            <div>

                <?php
                if (isset($_GET['num'])) {
                    $id = $_GET['num'];
                }
                $_SESSION['id'] = $id;

                echo '
                        <form action="php/update_desc.php" method="post">
                        <h3> Are you sure you want to delete this record?</h3>
                        <h3> Student ID: ' . $id . '</h3>
                        <input type="hidden" value="' . $id . '" name="id">
                        <button class="btn btn-success" name="Yes2">Yes</button>
                        <button class="btn btn-danger" name="No2">No</button>
                        </form>
                               ';

                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade be-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg" id="edit_lec">
        <div class="modal-content" id="non_center">
            <h2 class="text-center"> Edit Attendance </h2>
            <hr>
            <div>
                <?php
                if (isset($_GET['num'])) {
                    $id = $_GET['num'];
                }
                $_SESSION['id'] = $id;

                echo '
               <div class="alert alert-warning hidden">
                <span></span>
                <button type="button" class="close" onclick="$(\'.alert\').addClass(\'hidden\');">&times;</button>
            </div>
                <form id="attendance">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Student ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control-static send2"  value="' . $id . '" name="studid" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Class ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control send" placeholder="Class ID of class" name="classid" >
                        </div>
                     </div>
                     <button id="s_class" style="width:30%; margin-left:60%"> Search Class </button>

                </form>       
            </div>
        </div>';
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bf-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
>
    <div class="modal-dialog modal-lg" id="edit_lec">
        <div class="modal-content" id="non_center">
            <h2 class="text-center"> Edit Attendance </h2>
            <hr>
            <div>

                <?php
                if (isset($_GET['num'])) {
                    $id = $_GET['num'];
                }
                $_SESSION['id'] = $id;
                $class = "";
                $att = "";
                $had = "";
                if (isset($_SESSION['attend'])) {
                    $att = $_SESSION['attend'];
                }
                if (isset($_SESSION['class1'])) {
                    $class = $_SESSION['class1'];
                }
                if (isset($_SESSION['hadd'])) {
                    $had = $_SESSION['hadd'];
                }

                echo '
            <div class="alert alert-warning hidden">
                <span></span>
                <button type="button" class="close" onclick="$(\'.alert\').addClass(\'hidden\');">&times;</button>
            </div>
                <form class="form-horizontal large_modal" id="comattend" >
                    <div class="form-group">
                        <label class="control-label col-sm-2">Student ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  value="' . $id . '" name="Lec_ID" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Class ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  value="' . $class . '" name="Class_ID" readonly>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Classes Attended: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control"  placeholder="Insert No. of classes attended" value="' . $att . '" name="Attended">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Classes Conducted: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control"  value="' . $had . '" name="Had" readonly>
                            </div>
                        </div>
                       
                        <button class="btn btn-primary" id="add_lec" name="attend">Save Changes</button>
                </form>       
            </div>
        </div>';

                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade ba-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg" id="edit_lec">
        <div class="modal-content" id="non_center">
            <h2 class="text-center"> Assign Card </h2>
            <hr>
            <div>

                <?php
                $card = "";

                if (isset($_GET['num'])) {
                    $id = $_GET['num'];
                    $rows = $m->getStud_Card($id);
                    $m->debug_to_console(count($rows));

                    foreach ($rows as $row) {
                        $card = $row['NFC_uid'];
                    }

                }
                $_SESSION['id'] = $id;

                echo '
            <div class="alert alert-warning hidden">
                <span></span>
                <button type="button" class="close" onclick="$(\'.alert\').addClass(\'hidden\');">&times;</button>
            </div>
                <form class="form-horizontal large_modal" id="cardassign" >
                    <div class="form-group">
                        <label class="control-label col-sm-2">Student ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  value="' . $id . '" name="Lec_ID" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Card ID: </label>
                        <div class="col-sm-10 ok" ng-app="myApp" ng-controller="formCtrl">
                            <input class="form-control" TYPE="text" ng-model="cardno"  name="Card_ID" id="card">
                        </div>
                    </div>
                   <script>
                   var app = angular.module(\'myApp\', [\'ngRoute\']);

                            app.controller(\'formCtrl\', function ($scope) {
                                $scope.cardno = "John";
                            });
</script>
                    
       <div class="form-group">
        <div style="display:inline-flex; margin-bottom: 30px;">
                <div style="margin-left: 20px;" id="connect">
                    <object id="NFC_Applet"
                            code="NFC.NFC_Applet.class"
                            type="application/x-java-applet"
                            archive="HelloApplet.jar" height="200" width="250"
                            mayscript = "true" scriptable ="true"
                            align="middle" codebase="http:\\localhost\fyp\applet\">
                        <param name="mayscript" value="true" />
                    </object>

                   <!-- <applet id="NFC_Applet" code="NFC.NFC_Applet" scriptable ="true" MAYSCRIPT="true" archive="HelloApplet.jar" codebase="http:\\localhost\fyp\applet\" width="250" height="270"></applet>!-->

                </div>
               <div id="disconnect" style="float:right; margin-left: 20px;" >
                   <button class="btn btn-danger" id="disconnect"> Disconnect from Reader </button>
                </div>
            <!--<button class="btn btn-primary" id="connect"> Connect to Reader </button>
            !-->
        </div>
          </div>
                       
                        <button class="btn btn-primary" id="add_lec" name="assign">Save Changes</button>
                </form>       
            </div>
        </div>';

                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    /*
    $.ajax({
        url : 'php/attend.php',
        type : 'post',
        data : card,
        dataType : 'json',
        success : function(r) {
            console.log(r);
            switch(r.error) {
                case 'empty' :
                    $('.alert span').html('Please fill all the credentials !');
                    $('.alert').removeClass('hidden');
                    break;
                case 'not_found' :
                    $('.alert span').html('No such user found! Try signing up.');
                    $('.alert').removeClass('hidden');

                    break;
                case 'none' :
                    $('.alert span').html('Found!');
                    $('.alert').removeClass('hidden');
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    var ddl = document.getElementById('selectpicker');
                    var opts = ddl.options.length;
                    for (var i=0; i<opts; i++){
                        if (ddl.options[i].value == "2"){
                            ddl.options[i].selected = true;
                            break;
                        }
                    }
                    break;
            }
        }
    });
    */

    //$student = $m->isPresent($card);
    // $m->debug_to_console("card:".$card)?>

    //call PHP function//var studID = <?php //json_encode($student)?>;
    //console.log(studID);
    //get student ID from PHP function
    //check for student ID in table -- loop
    // get duration
    //if time is less that 3/4 of duration then late-row-orange
    //else then present -row-green
</script>
