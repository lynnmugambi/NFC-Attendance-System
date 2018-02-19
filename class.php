<?php
session_start();

$isIndex = 0;
if (!($_SESSION['type']) == 1 || !isset($_SESSION['type'])) {
    session_destroy();
    header('Location: logout.php');
    if (!$isIndex) header('Location: index.php');
}

include 'php/main_class.php';
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lecturer's Dashboard</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lecturer.js"></script>
    <script>
        $(document).ready(function (e) {
            $('.startsession').click(function (ev) {
                var check = <?php echo isset($_GET['lec_id']) ? 'true' : 'false'; ?>;
                console.log(check);

                if (check === false) {
                    ev.preventDefault();
                    alert("Please select one of the classes shown!  ");
                    return false;
                } else {
                    $('.bs-example-modal-lg').modal();
                }
            });
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
        <h2>Lecturer's Dashboard</h2>
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
            <li><a href="lecturer.php">Home</a></li>
            <li class="active"><a href="class.php">Classes</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<?php
echo '<div class="container"> 
      <h2>Welcome, ' . $_SESSION['username'] . '.</h2>';

$m = new Main();
$m->num_Classes($_SESSION['lec_id']);
$rowno = $_SESSION['rowno'];

if ($rowno == 0) {
    echo '<h4> You haven\'t been assigned any classes yet. Please see Admin for further information. </h4>';
} else {
    echo '<h3>Select class then click on button "open" to take attendance.</h3>';

    function display_tab($class_id,$classname,$start,$sem,$lec_id,$totalclass,$end,$desc,$duration,$day)
    {
        $sendstring = "class.php?class_id=$class_id&amp;classname=$classname&amp;start=$start&amp;sem=$sem&amp;lec_id=$lec_id&amp;totalclass=$totalclass&amp;end=$end&amp;desc=$desc&amp;duration=$duration&amp;day=$day";
        echo '<div class="class"> 
            <!--<button class="btn btn-danger delete-class-warning" data-toggle="modal" data-target=".delete-warning">&times;</button>!-->
            <a class="no-decoration" href="'.$sendstring.'">
            <div><strong>Module ID</strong> : <span class="classid">' . $class_id . '</span></div> 
            <div><strong>Module Name</strong> : <span class="classname">' . $classname . '</span></div> 
            <div><strong>Start Time</strong> : <span class="s_time">' . $start . '</span></div> 
            </a></div>
            
  ';
    }

    function getValues($days)
    {
        $m = new Main();
        $rows = $m->get_Classes($_SESSION['lec_id']);
        $m->debug_to_console(count($rows));


        foreach ($rows as $row) {

            $_SESSION['class_id'] = $row['ClassID'];
            $_SESSION['totalclass'] = $row['totalClasses'];
            $_SESSION['classname'] = $row['className'];
            $_SESSION['semester'] = $row['Semester'];
            $_SESSION['day'] = $row['Day'];
            $_SESSION['desc'] = $row['Description'];
            $_SESSION['start'] = $row['Start_Time'];
            $_SESSION['end'] = $row['End_Time'];
            $_SESSION['duration'] = $row['Duration'];

            $lec_id = $_SESSION['lec_id'];
            $class_id = $_SESSION['class_id'];
            $classname = $_SESSION['classname'];
            $totalclass = $_SESSION['totalclass'];
            $sem = $_SESSION['semester'];
            $day = $_SESSION['day'];
            $start = $_SESSION['start'];
            $end = $_SESSION['end'];
            $desc = $_SESSION['desc'];
            $duration = $_SESSION['duration'];

            if ($day == $days) {
                echo '<div class = "panel-body">';
                display_tab($class_id,$classname,$start,$sem,$lec_id,$totalclass,$end,$desc,$duration,$day);
                echo'<div id ="open" ><button class ="btn btn-primary startsession" > Open </button></div>';
                echo '</div>';
            }

        }

    }

    echo '<div class="container"> <div class = "panel-group">';

    echo '<div class = "panel panel-default">
          <h4 class = "panel-heading">Monday</h4>';
    getValues("Monday");
    echo '</div>';

    echo '<div class = "panel panel-default">
          <h4 class = "panel-heading">Tuesday</h4>';
    getValues("Tuesday");
    echo '</div>';

    echo '<div class = "panel panel-default">
          <h4 class = "panel-heading">Wednesday</h4>';
    getValues("Wednesday");
    echo '</div>';

    echo '<div class = "panel panel-default">
          <h4 class = "panel-heading">Thursday</h4>';
    getValues("Thursday");
    echo '</div>';

    echo '<div class = "panel panel-default">
          <h4 class = "panel-heading">Friday</h4>';
    getValues("Friday");
    echo '</div>';

    echo '</div> </div>';

    if (isset($_GET['lec_id'])){
    $_SESSION['lec_id'] = $_GET['lec_id'];
    $_SESSION['class_id'] = $_GET['class_id'];
    $_SESSION['classname'] = $_GET['classname'];
    $_SESSION['totalclass'] = $_GET['totalclass'];
    $_SESSION['semester'] = $_GET['sem'];
    $_SESSION['day'] = $_GET['day'];
    $_SESSION['start'] = $_GET['start'];
    $_SESSION['end'] = $_GET['end'];
    $_SESSION['desc'] = $_GET['desc'];
    $_SESSION['duration'] = $_GET['duration'];
    }

    $lec_id = $_SESSION['lec_id'];
    $class_id = $_SESSION['class_id'];
    $classname = $_SESSION['classname'];
    $totalclass = $_SESSION['totalclass'];
    $sem = $_SESSION['semester'];
    $day = $_SESSION['day'];
    $start = $_SESSION['start'];
    $end = $_SESSION['end'];
    $desc = $_SESSION['desc'];
    $duration = $_SESSION['duration'];



    echo '<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editprof"
     aria-hidden="true" >
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content" id="cont">
            <h2 class="text-center">'. $classname.'</h2>
            <div id="classdetails" >
                <form class="form-horizontal" method="post" name="user" action="">
                    <div class="form-group">
                        <label class = "control-label col-sm-2">Module ID: </label>
                        <div class="col-sm-10">
                            <p class="form-control-static" >'.$class_id.'</p>
                            <input type="hidden" name="classid" value="'.$class_id.'">
                            <input type="hidden" name="lecid" value="'.$lec_id.'">
                            <input type="hidden" name="classname" value="'.$classname.'">
                            <input type="hidden" name="totalclass" value="'.$totalclass.'">
                            <input type="hidden" name="sem" value="'.$sem.'">
                            <input type="hidden" name="day" value="'.$day.'">
                            <input type="hidden" name="startb" value="'.$start.'">
                            <input type="hidden" name="end" value="'.$end.'">  
                            <input type="hidden" name="duration" value="'.$duration.'">';
                        echo '</div>
                    </div>
                    <div class="form-group">
                        <label class = "control-label col-sm-2">Semester: </label>
                        <div class="col-sm-10">
                            <p class="form-control-static">'.$sem.'</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class = "control-label col-sm-2">Description: </label>
                        <div id="desc" class="col-sm-10">
                            <input type="text" class="form-control" name="desc" value="'.$desc.'">
                            <p class="form-control-static" ID="suggestion"> You can enter your customized descriptor for the class. e.g. SE-STATISTICS-MON-Morning </p>
                            <input type="submit" name="update_desc" value="Save Description" style="width:30%; margin-left:60%"
                             onclick="document.user.action=\'php/update_desc.php\'; 
                             document.user.target=\'_self\'; document.user.submit(); return true;">
                        </div>
                    </div>
                    <button class="btn btn-primary" id="sesh" onclick="document.user.action=\'attendance.php\'; document.user.target=\'_self\'; document.user.submit(); return true;" >Start Session</button>
                </form>
            </div>
        </div>
    </div>
</div>';
}
echo '</div>';

?>


</body>
</html>

