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
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="js/lecturer.js"></script>

    <script>$(document).ready(function (e) {

            var appletTag;
            var loop = 0;

            hideApplet(); // replace applet with clickable image

            function hideApplet() {
                var appletbox = document.getElementById('connect');
                appletTag = appletbox.innerHTML;

                appletbox.innerHTML = '<button class="btn btn-primary">Connect to Reader</button>';
            }

            var ready = false;
            var timer;

            $("#connect").click(function () {
                showApplet();

                function showApplet() { //show applet iframe
                    var appletbox = document.getElementById('connect');
                    appletbox.innerHTML = appletTag;
                    timer = setTimeout(function () {
                        startRead(true);
                    }, 2000);
                }

                ready = true;
            });


            function startRead(repeat) {
                var uidfound = "not found"
                if (repeat === true && loop < 2) {

                    if (ready === true) {

                        var uid = document.getElementById("NFC_Applet");
                        console.log("starting");
                        uidfound = uid.getUID().getRV();
                        var card = uidfound;
                        console.log(card);

                        var cardNumber = document.getElementById('myInput');
                        cardNumber.value = card ;

                        var input, filter, table, tr, td, i;
                        input = document.getElementById("myInput");
                        filter = input.value.toUpperCase();
                        table = document.getElementById("example");
                        tr = table.getElementsByTagName("tr");

                        // Loop through all table rows, and hide those who don't match the search query
                        for (i = 0; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[2];
                            if (td) {
                                if (td.innerHTML.toUpperCase().indexOf(card)+ " " > -1) {
                                    tr[i].style.display = "";

                                    var row = td.parentNode;
                                    var combo = row.getElementsByTagName('select');
                                    $(row).attr('class', 'table-success');
                                    $(combo).val('');
                                    $(combo).val("2");
                                     }
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }


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
                    console.log('stopped');
                    ready = false;
                }
            }


            $("#disconnect").click(function (e) {
                e.preventDefault();
                ready = false;
                startRead(false);
            });
        });

        $(document).ready(function () {
            var formmodified = 1;
            window.onbeforeunload = confirmExit;

            function confirmExit() {
                if (formmodified === 1) {
                    return "New information not saved. Do you wish to leave the page?";
                }
            }

            $("button[name='submit']").click(function () {
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
            echo '<div class="make"><strong>Today\'s Date</strong> : <span>' . date("d-m-Y") . '</span></div>
            <br>
            	 ';

            echo ' <button data-toggle="collapse" data-target="#demo" class="btn btn-primary ">Help Me!</button> 
               <div id="demo" class="collapse">
               <h4 class="text-center text-primary"> Instructions </h4>
          <p> To take attendance, please ensure NFC reader is connected before student taps on the device. Thereafter, click on the connect button. You may also change the attendance manually if needed.</p>
          <p class="text-danger"><strong>Contact technical support immediately if you experience any issue with the site.</strong></p></div>
           ';

            ?>

        </div>
        <div class="left-header" style="width: 60%;display: inline-block;">
            <div class="class-info">
                <?php $today = date("m/d/Y");
                echo '
            <div><strong>Start Time</strong> : <span >' . $start . '</span></div> 
            <div><strong>End Time</strong> : <span >' . $end . '</span></div> 
            <div><strong>Duration</strong> : <span >' . $duration . ' hr(s)</span></div> 
            <div id="time"><strong>Time Remaining</strong> : <span><script language="JavaScript">
                                                        var endtime = ' . json_encode($end) . ';
                                                        var today = ' . json_encode($today) . ';
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
            <div >
                <div id="connect" style="margin: 5px;">
                    <object id="NFC_Applet"
                            code="NFC.NFC_Applet.class"
                            type="application/x-java-applet"
                            archive="HelloApplet.jar" height="200" width="250"
                            mayscript="true" scriptable="true"
                            align="middle" codebase="http:\\localhost\fyp\applet\">
                        <param name="mayscript" value="true"/>
                    </object>

                </div>
                <div id="disconnect"  style="margin-left: 5px;" >
                    <button class="btn btn-danger" id="disconnect"> Disconnect from Reader</button>
                </div>

            </div>
        </div>
    </div>
    <div class="panel-footer Studenttable">
        <form action="php/save_attendance.php" method="post">
            <input type="text" id="myInput" placeholder="Search for NFC ID..">
            <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                <thead>
                <tr>

                    <th>Student Name</th>
                    <th>Student No.</th>
                    <th>NFC ID</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $rows = $m->getStudents2($class_id);
                foreach ($rows as $key => $row) {
                    $i = 0;
                    echo '<tr class="table-danger">
        
        <td >' . $row[$i]['Name'] . '</td>
        <td >' . $row[$i]['StudentID'] . '</td>
        <td> ' . $row[$i]['NFC_uid'] . '</td>
        <input type="hidden" name = "TPNo[]" value="' . $row[$i]['StudentID'] . '">
        
        <td ><div>
            <select name="status[]" id="combobox">
                <option id = "absent" value= "1" selected >Absent</option>
                <option id = "present" value="2">Present</option>
                <option id = "late" value="3">Late</option>
                <option id = "reason" value="4">Absent with Reason</option>
            </select>
            </div>
        </td>
        </tr> ';
                    $i++;
                }
                ?>
                </tbody>
            </table>
            <button id="submit" name="submit" class="btn btn-success">Save Records</button>
            <br>
        </form>
        <script>


        </script>
    </div>


</div>
</body>
</html>


