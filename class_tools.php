<?php
session_start();
$isIndex = 0;
if(!($_SESSION['type'])==0  || !isset($_SESSION['type'])) {
    session_destroy();
    header('Location: logout.php');
    if(!$isIndex) header('Location: index.php');}
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
    <script src="js/lecturer.js"></script>
    <script>$(document).ready(function () {
            if (!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            } else {
                //$('.selectpicker').selectpicker();

                $('#class_table tr').click(function () {
                    const num = $(this).find("input").attr("value");
                    if (num) {
                        window.location.href = "class_tools.php?num=" + num;
                    }
                });
                $('#course_table tr').click(function () {
                    const course = $(this).find("input").attr("value");
                    if (course) {
                        window.location.href = "class_tools.php?course=" + course;
                    }
                });
                $('#ctoc_table tr').click(function () {
                    const course = $(this).find("input").attr("value");
                    if (course) {
                        window.location.href = "class_tools.php?class=" + course;
                    }
                });

                $('#details').click(function (ev) {
                    var check = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the CLASS table below!");
                        return false;
                    } else {
                        $('.bt-example-modal-lg').modal();
                    }
                });

                $('#delete').click(function (ev) {
                    var check = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the CLASS table below!");
                        return false;
                    }
                    else {
                        $('.bd-example-modal-lg').modal();
                    }
                });
                $('#delete_c').click(function (ev) {
                    var check = <?php echo isset($_SESSION['course']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the COURSE table below!");
                        return false;
                    }
                    else {
                        $('.be-example-modal-lg').modal();
                    }
                });
                $('#delete_c2').click(function (ev) {
                    var check = <?php echo isset($_SESSION['class']) ? 'true' : 'false'; ?>;
                    console.log(check);

                    if (check === false) {
                        ev.preventDefault();
                        alert("Please select one of the rows in the Class to Course table below!");
                        return false;
                    }
                    else {
                        $('.bf-example-modal-lg').modal();
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
            <li ><a href="admin.php">Home</a></li>
            <li><a href="lec_tools.php">Lecturer Tools</a></li>
            <li><a href="stud_tools.php">Student Tools</a></li>
            <li class="active"><a href="class_tools.php">Class Tools</a></li>
            <li><a href="stats_admin.php">View Attendance</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container panel panel-default">
    <div class="panel-heading top" style="height: 250px;">
        <div >
            <?php
            echo '<h1>Welcome , ' . $_SESSION['username'] . '</h1>';
            echo '<div class="row rowx"><div class="first"><h2 >You may add a new class by : </h2></div>
                  <div class="second"><button class="btn btn-success" style="margin-left: 20px;" data-toggle="modal" data-target=".bs-example-modal-lg">Add New Class</button>
                   <button class="btn btn-success" style="margin-left: 20px;" data-toggle="modal" data-target=".bb-example-modal-lg">Add New Course</button>
                  <button class="btn btn-success" style="margin-left: 20px;" data-toggle="modal" data-target=".bg-example-modal-lg">Assign New Class to Course</button></div></div>';
            echo '<div class="row rowx"><div class="first"><h2>Or, for existing classes : </h2> </div>
                    <div class="second">
                    <button class="btn btn-primary" style="margin-left: 20px;" id="details">Edit Class Details</button>
                    <button class="btn btn-warning" style="margin-left: 20px;" id="delete">Delete Class</button>
                    <button class="btn btn-warning" style="margin-left: 20px;" id="delete_c">Delete Course</button>
                    <button class="btn btn-warning" style="margin-left: 20px;" id="delete_c2">Delete Class to Course</button>
                    </div></div>';
            ?>
        </div>
    </div>
    <div class="panel-footer Studenttable">
            <table class="table table-bordered table-hover" id="class_table">
                <thead>
                <tr>
                    <th>Module ID</th>
                    <th>Module Name</th>
                    <th>Total Classes</th>
                    <th>Total Hours</th>

                </tr>
                </thead>

                <tbody>
                <?php
                $m = new Main();
                $rows = $m->getClass();
                $m->debug_to_console(count($rows));

                foreach ($rows as $row) {
                    echo '<tr>
<input type="hidden" value="' . $row['ClassID'] . '">
        <td >' . $row['ClassID'] . '</td>
        <td >' . $row['className'] . '</td>
        <td >' . $row['totalClasses'] . '</td>
        <td >' . $row['totalHours'] . '</td> 
      </tr>';
                }
                ?>
                </tbody>
            </table>
        <br>
        <table class="table table-bordered table-hover" id="course_table">
        <thead>
        <tr>

            <th>Course ID</th>
            <th>Course Name</th>
            <th>Department</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $m = new Main();
        $rows = $m->getCourse();
        $m->debug_to_console(count($rows));

        foreach ($rows as $row) {
            echo '<tr>
<input type="hidden" value="' . $row['CourseID'] . '">
        <td >' . $row['CourseID'] . '</td>   
        <td >' . $row['Course_Name'] . '</td>
        <td >' . $row['Department'] . '</td>
      </tr>';
        }
        ?>
        </tbody>
        </table>
        <table class="table table-bordered table-hover" id="ctoc_table">
            <thead>
            <tr>

                <th>Class ID</th>
                <th>Course ID</th>

            </tr>
            </thead>

            <tbody>
            <?php
            $m = new Main();
            $rows = $m->getCtoC();
            $m->debug_to_console(count($rows));

            foreach ($rows as $row) {
                echo '<tr>
<input type="hidden" value="' . $row['ClassID'] . '">
        <td >' . $row['ClassID'] . '</td>   
        <td >' . $row['CourseID'] . '</td>
        
      </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
     aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="non_center">
            <h2 class="text-center"> Add New Class </h2>
            <hr>
            <div>
                <form class="large_modal" action="php/add_user.php" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Module Name: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" placeholder="Name" type="name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Total Classes: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  name="classes">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Total Hours: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  name="hrs">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> Course ID: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  name="cid">
                        </div>
                    </div>
                    <button class="btn btn-primary" id="add_lec" name="add_class">Save Class</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade bb-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
         aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Add New Course </h2>
                <hr>
                <div>
                    <form class="large_modal" action="php/add_user.php" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2"> Course Name: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Name" type="name" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2"> Department: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Eg. Computing" name="dept">
                            </div>
                        </div>

                        <button class="btn btn-primary" id="add_lec" name="add_course">Save Class</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bg-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby=""
         aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Add New Course </h2>
                <hr>
                <div>
                    <form class="large_modal" action="php/add_user.php" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2"> Class ID: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Class ID" name="classid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2"> Course ID: </label>
                            <div class="col-sm-10 ok">
                                <input class="form-control" placeholder="Course ID" name="course">
                            </div>
                        </div>

                        <button class="btn btn-primary" id="add_lec" name="add_c2c">Save Relationship</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bt-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content" id="non_center">
                <h2 class="text-center"> Edit Class Details </h2>
                <hr>
                <div>
                    <?php
                    $name = "";
                    $t_class = "";
                    $t_hrs = "";
                    $course = "";
                    if (isset($_GET['course'])) {
                        $id2 = $_GET['course'];
                    }
                    $_SESSION['course'] = $id2;


                    if (isset($_GET['num'])) {
                        $id = $_GET['num'];
                        $rows = $m->getClass_Det($id);
                        $m->debug_to_console(count($rows));

                        foreach ($rows as $row) {
                            $name = $row['className'];
                            $t_class = $row['totalClasses'];
                            $t_hrs = $row['totalHours'];
                            $course = $row['CourseID'];
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
                        <label class="control-label col-sm-2"> Total Classes: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control"  name="class" value="' . $t_class . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Total Hours: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="hrs" value="' . $t_hrs. '">
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-sm-2"> Course: </label>
                        <div class="col-sm-10 ok">
                            <input class="form-control" name="course" value="' . $course . '">
                        </div>
                    </div>
                   
                    <button class="btn btn-primary" id="add_lec" name="save_class">Save Changes</button>
                </form>
            </div>
        </div>';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
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
                        <h3> CLASS ID: '.$id.'</h3>
                        <input type="hidden" value="' . $id . '" name="id">
                        <button class="btn btn-success" name="Yes3">Yes</button>
                        <button class="btn btn-danger" name="No3">No</button>
                        </form>
                               ';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade be-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content">
                <h2 class="text-center"> Delete Record </h2>
                <hr>
                <div>

                    <?php
                    if (isset($_GET['course'])) {
                        $id2 = $_GET['course'];
                    }
                    $_SESSION['course'] = $id2;

                    echo '
                        <form action="php/update_desc.php" method="post">
                        <h3> Are you sure you want to delete this record?</h3>
                        <h3> COURSE ID: '.$id2.'</h3>
                        <input type="hidden" value="' . $id2 . '" name="id2">
                        <button class="btn btn-success" name="Yes4">Yes</button>
                        <button class="btn btn-danger" name="No4">No</button>
                        </form>
                               ';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bf-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog modal-lg" id="edit_lec">
            <div class="modal-content">
                <h2 class="text-center"> Delete Record </h2>
                <hr>
                <div>

                    <?php
                    if (isset($_GET['class'])) {
                        $id3 = $_GET['class'];
                    }
                    $_SESSION['class'] = $id3;

                    echo '
                        <form action="php/update_desc.php" method="post">
                        <h3> Are you sure you want to delete this record?</h3>
                        <h3> CLASS ID: '.$id3.'</h3>
                        <input type="hidden" value="' . $id3 . '" name="id3">
                        <button class="btn btn-success" name="Yes5">Yes</button>
                        <button class="btn btn-danger" name="No5">No</button>
                        </form>
                               ';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>