<?php
session_start();
$isIndex = 0;
if (!($_SESSION['type']) == 0 || !isset($_SESSION['type'])) {
    session_destroy();
    header('Location: logout.php');
    if (!$isIndex) header('Location: index.php');
}
include './php/main_class.php';
$i = new Main();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin's Dashboard</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <script src="js/bootstrap-select.js"></script>
    <script src="js/admin.js"></script>
    <script>$(document).ready(function () {
            if (!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            } else {
                $('.selectpicker').selectpicker();

                $('#lec_table tr').click(function () {
                    var num = $(this).find("input").attr("value");
                    if (num) {
                        window.location.href = "lec_tools.php?num=" + num;
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
                    } else {
                        $('.bd-example-modal-lg').modal();
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
            <li class="active"><a href="lec_tools.php">Lecturer Tools</a></li>
            <li><a href="stud_tools.php">Student Tools</a></li>
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
            echo '<h1 style="margin-top: 5px;">Welcome , ' . $_SESSION['username'] . '</h1>';
            echo '<div class="row rowx"><div class="first"><h2 >You may add a new user by : </h2></div>
                   <div class="second">
                   <button class="btn btn-success" style="margin-left: 20px" data-toggle="modal" data-target=".bs-example-modal-lg">Add New User</button> </div></div>';
            echo '<div class="row rowx"><div class="first"><h2>Or, for existing users : </h2> </div>
                    <div class="second"> 
                    <button class="btn btn-primary" style="margin-left: 20px;" id="details" >Edit Lecturer Details</button>
                    <button class="btn btn-primary" style="margin-left: 20px;" id="assign">Assign Classes</button>
                    <button class="btn btn-warning" style="margin-left: 20px;" id="delete">Delete User</button></div>
                    </div>
          
                    <h4 style="margin-top: 20px;"> NB: To edit, select row then click on desired function. </h4></div>';
            ?>

        </div>

        <div class="panel-footer studenttable">
            <table class="table table-bordered table-hover" id="lec_table">
                <thead>
                <tr>
                    <th>Lec ID</th>
                    <th>Lec Name</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Type</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $m = new Main();
                $rows = $m->getLec();
                $m->debug_to_console(count($rows));

                foreach ($rows as $row) {
                    echo '<tr >
       <input type="hidden" value="' . $row['LecID'] . '">
        <td >' . $row['LecID'] . '</td>
        <td >' . $row['offName'] . '</td>
        <td >' . $row['Dept'] . '</td>
        <td >' . $row['Email'] . '</td>
        <td >' . $row['Username'] . '</td>   
        <td >' . $row['Password'] . '</td> 
        <td >' . $row['Type'] . '</td> 
      </tr>';
                }
                ?>
                </tbody>
            </table>
<br>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Lec ID</th>
                    <th>Class ID</th>
                    <th>Semester</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Duration</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $m = new Main();
                $rows = $m->getAss();
                $m->debug_to_console(count($rows));

                foreach ($rows as $row) {
                    echo '<tr >
        <td >' . $row['LecID'] . '</td>
        <td >' . $row['ClassID'] . '</td>
        <td >' . $row['Semester'] . '</td>
        <td >' . $row['Day'] . '</td>
        <td >' . $row['Start_Time'] . '</td>   
        <td >' . $row['End_Time'] . '</td> 
        <td >' . $row['Duration'] . '</td> 
      </tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
    >
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Add New User </h2>
                <hr>
                <div>
                    <form class="form-horizontal large_modal" action="php/add_user.php" method="post">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Title: </label>
                            <div class="col-sm-10">
                                <div class="sel">
                                    <select class="selectpicker" name="title">
                                        <option value=""> --Please select one option--</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof.">Prof.</option>
                                        <option value="Miss.">Miss.</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Official Name: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Name" type="name" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Department: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Department" name="dept">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Email: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Email Address" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Username: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Choose a unique username" name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Password: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Password" name="password">
                            </div>
                        </div>
                        <button class="btn btn-primary" id="add_lec" name="add_lec">Save User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bt-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
    >
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Edit Lecturer Details </h2>
                <hr>
                <div>
                    <?php
                    $name = "";
                    $pass = "";
                    $email = "";
                    $uname = "";
                    $dept = "";

                    if (isset($_GET['num'])) {
                        $id = $_GET['num'];
                        $rows = $m->getLec_Det($id);
                        $m->debug_to_console(count($rows));

                        foreach ($rows as $row) {
                            $name = $row['offName'];
                            $dept = $row['Dept'];
                            $email = $row['Email'];
                            $uname = $row['Username'];
                            $pass = $row['Password'];
                        }

                    }
                    $_SESSION['id'] = $id;

                    echo '
                <form class="form-horizontal large_modal" action="php/update_desc.php" method="post">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Lecturer ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control-static"  value="' . $id . '" name="id" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Official Name: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="Name"  name="name" value="' . $name . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Department: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  name="dept" value="' . $dept . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="email" value="' . $email . '">
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-sm-2">Username: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="uname" value="' . $uname . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Password: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="pass" value="' . $pass . '">
                        </div>
                    </div>
                    <button class="btn btn-primary" id="add_lec" name="save_lec">Save Changes</button>
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
                <h2 class="text-center"> Assign Classes </h2>
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
                <form id="searchclass">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Lecturer ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control-static send2"  value="' . $id . '" name="lecid" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Class ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control send" placeholder="Class ID of class to be assigned" name="classid" >
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

    <div class="modal fade bb-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
    >
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Assign Classes </h2>
                <hr>
                <div>

                    <?php
                    if (isset($_GET['num'])) {
                        $id = $_GET['num'];
                    }
                    $_SESSION['id'] = $id;
                    $class="";
                    if(isset($_SESSION['class'])){
                        $class = $_SESSION['class'];
                    }
                    //$m->debug_to_console("class:" . $class);
                    $rows = $m->searchClass2($class, $_SESSION['id']);
                    $m->debug_to_console(count($rows));
                    foreach ($rows as $row) {

                        echo '
            <div class="alert alert-warning hidden">
                <span></span>
                <button type="button" class="close" onclick="$(\'.alert\').addClass(\'hidden\');">&times;</button>
            </div>
                <form class="form-horizontal large_modal" id="comassign" >
                    <div class="form-group">
                        <label class="control-label col-sm-2">Lecturer ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  value="' . $id . '" name="Lec_ID" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Class ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  value="' .$row['ClassID'] . '" name="Class_ID" readonly>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Semester: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control"  placeholder="E.g. Y*-S*" value="' . $row['Semester'] . '" name="Semester">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Day: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. Monday" value="' . $row['Day'] . '" name="Day">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Start Time: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. 09:00 AM" value="' . $row['Start_Time'] . '" name="Start_Time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">End Time: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. 11:00 AM " value="' . $row['End_Time'] . '" name="End_Time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Duration: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. 2 " value="' . $row['Duration'] . '" name="Duration">
                            </div>
                        </div>
                        <button class="btn btn-primary" id="add_lec" name="assign">Save Changes</button>
                </form>       
            </div>
        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bc-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
    >
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Assign Classes </h2>
                <hr>
                <div>

                    <?php
                    if (isset($_GET['num'])) {
                        $id = $_GET['num'];
                    }
                    $_SESSION['id'] = $id;
                    $class = "";
                    if (isset($_SESSION['class'])) {
                        $class = $_SESSION['class'];
                    }
                    echo '
            <div class="alert alert-warning hidden">
                <span></span>
                <button type="button" class="close" onclick="$(\'.alert\').addClass(\'hidden\');">&times;</button>
            </div>
                <form class="form-horizontal large_modal" id="incomassign">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Lecturer ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control send"  value="' . $id . '" name="Lec_ID" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Class ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  value="' .$class. '" name="Class_ID" readonly>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Semester: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control"  placeholder="E.g. Y*-S*"  name="Semester">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Day: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. Monday" name="Day">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Start Time: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. 09:00 AM"  name="Start_Time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">End Time: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. 11:00 AM "  name="End_Time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Duration: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="E.g. 2 "  name="Duration">
                            </div>
                        </div>
                        <button class="btn btn-primary" id="add_lec">Save Changes</button>
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
                        <h3> Lec ID: ' . $id . '</h3>
                        <input type="hidden" value="' . $id . '" name="id">
                        <button class="btn btn-success" name="Yes">Yes</button>
                        <button class="btn btn-danger" name="No">No</button>
                    </form>';
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>


