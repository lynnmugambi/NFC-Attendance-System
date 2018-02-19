<?php
session_start();

$isIndex = 0;
if (!($_SESSION['type']) == 1 || !isset($_SESSION['type'])) {
    session_destroy();
    header('Location: logout.php');
    if (!$isIndex) header('Location: index.php');
}

include 'php/main_class.php';
$m = new Main();

$desc = "";
$class_id = "";
$lec_id = "";
$classname = "";
$totalclass = "";
$sem = "";
$day = "";
$start = "";
$end = "";
$duration = "";

if (isset($_POST['desc'])) {
    $desc = $_POST['desc'];
    $m->debug_to_console($desc);
}
if (isset($_POST['classid'])) {
    $class_id = $_POST['classid'];
    $m->debug_to_console($class_id);
}
if (isset($_POST['lecid'])) {
    $lec_id = $_POST['lecid'];
    $m->debug_to_console($lec_id);
}
if (isset($_POST['totalclass'])) {
    $totalclass = $_POST['totalclass'];
    $m->debug_to_console($totalclass);
}
if (isset($_POST['sem'])) {
    $sem = $_POST['sem'];
    $m->debug_to_console($sem);
}
if (isset($_POST['day'])) {
    $day = $_POST['day'];
    $m->debug_to_console($day);
}
if (isset($_POST['startb'])) {
    $start = $_POST['startb'];
    $m->debug_to_console($start);
}
if (isset($_POST['end'])) {
    $end = $_POST['end'];
    $m->debug_to_console($end);
}
if (isset($_POST['duration'])) {
    $duration = $_POST['duration'];
    $m->debug_to_console($duration);
}

$_SESSION['lec_id'] = $lec_id;
$_SESSION['class_id'] = $class_id;
$_SESSION['classname'] = $classname;
$_SESSION['totalclass'] = $totalclass;
$_SESSION['semester'] = $sem;
$_SESSION['day'] = $day;
$_SESSION['start'] = $start;
$_SESSION['end'] = $end;
$_SESSION['desc'] = $desc;
$_SESSION['duration'] = $duration;
//unset($_SESSION['studid2']);
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Take Attendance</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/lecturer.js"></script>
    <script>$(document).ready(function(e) {
            $('.selectpicker').selectpicker();

            var appletTag;
            var loop = 0;

            hideApplet(); // replace applet with clickable image

            function hideApplet(){
                var appletbox=document.getElementById('connect');
                appletTag = appletbox.innerHTML;

                appletbox.innerHTML='<button class="btn btn-primary">Connect to Reader</button>';
            }

            var ready = false;

            $("#connect").click(function() {
                showApplet();

                function showApplet() {
                    var appletbox = document.getElementById('connect');
                    appletbox.innerHTML = appletTag ;
                    startRead(true);
                }

                ready = true;
            });

            var timer;
            var timer2;
            var test = "testing"

            function startRead(repeat) {
                var uidfound = "not found"
                if (repeat === true && loop < 2 ) {

                    if (ready === true) {

                        var uid = document.getElementById("NFC_Applet");
                        console.log("starting");
                        uidfound = uid.getUID().getRV();
                        var card = uidfound;
                        console.log(card);

                        //Loading the info on the page using Ajax
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

                                }
                            }
                        });

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


            $("#disconnect").click(function(e) {
                e.preventDefault();
                ready = false;
                startRead(false);
            });
        });
        $(document).ready(function() {
            var formmodified=1;
            window.onbeforeunload = confirmExit;
            function confirmExit() {
                if (formmodified === 1) {
                    return "New information not saved. Do you wish to leave the page?";
                }
            }
            $("button[name='submit']").click(function() {
                formmodified = 0;
            });
        });

    </script>
    <script type="text/javascript">

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
            <li><a href="class.php">Classes</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container panel panel-default">
    <div class="panel-heading top">
        <div class="main-header">
            <?php
            echo '<h1>Welcome , ' . $_SESSION['username'] . '</h1>';
            echo '<div class="make"><strong>Today\'s Date</strong> : <span>'.date("d-m-Y").'</span></div>
            <br>
            	 ';

            echo ' <button data-toggle="collapse" data-target="#demo" class="btn btn-primary ">Help Me!</button> 
               <div id="demo" class="collapse">
               <h4 class="text-center text-primary"> Instructions </h4>
          <p> Ensure Student card is tapped once on entry and once on exit to take attendance. You may also change the attendance manually if needed.</p>
          <p class="text-danger"><strong>Contact technical support immediately if you experience any issue with the site.</strong></p></div>
           ';

            ?>
            <div class="alert alert-warning hidden">
                <span></span>
                <button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
            </div>
        </div>
        <div class="left-header" style="width: 60%;display: inline-block">
        <div class="class-info">
            <?php $today = date("m/d/Y");
            echo '
            <div><strong>Start Time</strong> : <span >' . $start . '</span></div> 
            <div><strong>End Time</strong> : <span >' . $end . '</span></div> 
            <div><strong>Duration</strong> : <span >' . $duration . 'hr(s)</span></div> 
            <div><strong>Time Remaining</strong> : <span><script language="JavaScript">
                                                        var endtime = '.json_encode($end).';
                                                        var today = '.json_encode($today).';
                                                        var stop = today + " " + endtime;
                                                        console.log(stop);
                                                        TargetDate = stop;
                                                        CountActive = true;
                                                        CountStepper = -1;
                                                        LeadingZero = true;
                                                        DisplayFormat = "%%H%% Hrs, %%M%% Min, %%S%% Sec.";
                                                        FinishMessage = "Session Time Ended";
</script>
<script language="JavaScript" src="js/countdown.js"></script></span></div>'; ?>

        </div>
        <div style="">
                <div id="connect">
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
               <div id="disconnect">
                   <button class="btn btn-danger" id="disconnect"> Disconnect from Reader </button>
                </div>
            <!--<button class="btn btn-primary" id="connect"> Connect to Reader </button>
            !-->
        </div>
        </div>
    </div>
    <div class="panel-footer Studenttable">
        <form action="php/save_attendance.php" method="post">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Student Name</th>
                <th>Student No.</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rows = $m->getStudents2($class_id);
            foreach ($rows as $key => $row) {
                $i = 0;
                echo '<tr>
        <td >' . $row[$i]['Name'] . '</td>
        <td >' . $row[$i]['StudentID'] . '</td>
        <input type="hidden" name = "TPNo[]" value="'.$row[$i]['StudentID'].'">
        <td ><div>
            <select class="selectpicker" name="status[]" id="selectpicker">
                <option value=1 selected ="selected">Absent</option>
                <option value=2>Present</option>
                <option value=3>Late</option>
                <option value=4>Absent with Reason</option>
            </select>
            </div>
        </td>
        </tr> '; $i++;
            }
            ?>
            </tbody>
        </table>
        <button id="submit" name = "submit" class="btn btn-success">Save Records</button> <br>
        </form>
    </div>


</div>
</body>
</html>
<!--<form class="form-horizontal"  role="form">
<div class="form-group">
    <label for="dtp_input2" class="col-md-2 control-label">Date :</label>
    <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
        <input class="form-control" size="16" type="text" value="" readonly>
        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
    <input type="hidden" id="dtp_input2" value="" /><br/>
</div>
<script type="text/javascript">
    $('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });</script> </form> --!>


