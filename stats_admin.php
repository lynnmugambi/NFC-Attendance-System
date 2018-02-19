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
<html>
<head>
    <link rel="stylesheet" href="css/style.css"/>
    <title>Statistics</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js">></script>
    <script src="js/highcharts-exporting.js"></script>
    <!--<script src="js/statistics.js"></script>!-->
    <script>
        $(document).ready(function() {
            if(window.location.hash === "#loaded") {
                Chart();
            }
            else {

                $(function () {
                    var myChart = Highcharts.chart('container2', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Student Attendance Example Chart'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Percentage',
                            colorByPoint: true,
                            data: [{
                                name: 'Classes Attended',
                                y: 1.0
                            }, {
                                name: 'Classes Missed',
                                y: 99.00,
                                sliced: true,
                                selected: true
                            }]
                        }]
                    });
                });
                searchChart();

            }
        });

        function searchChart() {

                $("#chart").click(function () {
                    var data = {};

                    $("#chart").find("input").each(function (k, v) {
                        if (!$(v).val().length) {
                            $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                            $('.alert').removeClass('hidden');
                            return false;
                        }
                        data[$(v).attr('name')] = $(v).val();
                    });

                    $.ajax({
                        url: 'php/get_attendance.php',
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        success: function (r) {
                            console.log(r);
                            switch (r.error) {

                                case 'not_found' :
                                    $('.alert span').html('No such record found!');
                                    $('.alert').removeClass('alert-danger');
                                    $('.alert').removeClass('alert-success');
                                    $('.alert').addClass('alert-warning');
                                    $('.alert').removeClass('hidden');
                                    break;
                                case 'no_class' :
                                    $('.alert span').html('No attendance found for this class in database!');
                                    $('.alert').removeClass('alert-danger');
                                    $('.alert').removeClass('alert-success');
                                    $('.alert').addClass('alert-warning');
                                    $('.alert').removeClass('hidden');
                                    break;
                                case 'none' :
                                    $('.alert span').html('<img src="img/loading.gif"> <Strong>Success</strong>, record found! ');
                                    $('.alert').removeClass('hidden');
                                    $('.alert').removeClass('alert-warning');
                                    $('.alert').removeClass('alert-danger');
                                    $('.alert').addClass('alert-success');
                                    setTimeout(function () {
                                        $('.alert').hide();
                                        window.location = window.location + '#loaded';
                                        location.reload();

                                    }, 1000);
                                    break;
                            }
                        }
                    });
                    return false
                });

        }
        function Chart() {

            <?php
                $att=0;
                $had=0;
                $tp="";
                $class="";
            if (isset($_SESSION['had'])) {
                $had = (int)$_SESSION['had'];
            }
            if (isset($_SESSION['att'])) {
                $att = (int)$_SESSION['att'];
            }
            if (isset($_SESSION['stud'])) {
                $tp = $_SESSION['stud'];
            }
            if (isset($_SESSION['class1'])) {
                $class = $_SESSION['class1'];
            }

            $patt = 0;
            $pmiss = 0;

            if($had > 0){
            $patt = ($att/$had)*100;
            $pmiss = 100 - $patt;
            }
            else{
                $m = new Main();
                //$m->phpAlert("Error with page, please see website administrator!","stats_admin.php");
            }


                ?>

                var myChart = Highcharts.chart('container2', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Attendance for Student ID: <?php echo $tp ?> in Class ID:<?php echo $class ?> '
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Percentage',
                        colorByPoint: true,
                        data: [{
                            name: 'Classes Attended',
                            y: <?php echo ($patt); ?>
                        }, {
                            name: 'Classes Missed',
                            y: <?php echo ($pmiss); ?>,
                            sliced: true,
                            selected: true
                        }]
                    }]
                });

                removeHash();
                searchChart();

        }
        function removeHash () {
            history.pushState("", document.title, window.location.pathname
                + window.location.search);
        }


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
            <li><a href="stud_tools.php">Student Tools</a></li>
            <li><a href="class_tools.php">Class Tools</a></li>
            <li class="active"><a href="stats_admin.php">View Attendance</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="wrapper">
        <div>
            <form class="form-inline" id="chart" >
                <div class="form-group">
                    <label for ="tp">Enter Student ID: </label>
                    <input class="form-control" placeholder="Student ID" name="studID" >
                </div>
                <div class="form-group" style="margin-left: 20px;">
                    <label for="classid">Enter Class ID: </label>
                    <input class="form-control" placeholder="Class ID" name="classID">
                </div>
                <button type="submit"  name ="submit" class="btn btn-primary" style="margin-left: 20px;margin-top: 20px;">Submit</button>
            </form>
        </div>

        <div class="alert alert-warning hidden">
            <span></span>
            <button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
        </div>

        <div id="container2" style="width:100%; height:400px;">

        </div>
        <div class="explain">
            <div style="margin-right: 20px;">
              <h4>Classes Attended: <?php
                  $had=0;$att=0;
                  if (isset($_SESSION['had'])) {
                      $had = (int)$_SESSION['had'];
                  }
                  if (isset($_SESSION['att'])) {
                      $att = (int)$_SESSION['att'];
                  }
                  echo $att ?></h4>
            </div>
            <div style="float: right;">
                <h4> Classes Missed: <?php $miss = $had - $att; echo $miss?>
            </div>
        </div>

</div>
</div>
</body>
</html>
