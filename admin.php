<?php

session_start();
$isIndex = 0;
if(!($_SESSION['type'])==0 || !isset($_SESSION['type'])) {
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
    <script src="js/admin.js"></script>


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
            <li class="active"><a href="admin.php">Home</a></li>
            <li><a href="lec_tools.php">Lecturer Tools</a></li>
            <li><a href="stud_tools.php">Student Tools</a></li>
            <li><a href="class_tools.php">Class Tools</a></li>
            <li><a href="stats_admin.php">View Attendance</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container ">
    <div class="row">
        <h2 class="con">Account</h2>
    </div>

    <?php
    $m = new Main;
    $m->get_Profile2($_SESSION['username']);

    $admin_id = $_SESSION['admin_id'];
    $title = $_SESSION['title'];
    $dept = $_SESSION['dept'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $username = $_SESSION['username'];
    $picture = $_SESSION['image'];
    echo '<h2 class="con">Welcome, ' . $_SESSION['username'] . '.</h2>';
    echo '<div class="row">
        <div class="profile-header-container">
            <div class="profile-header-img">';
    if (!isset($_SESSION['image']) || empty($_SESSION['image'])) {
        echo '<img class="img-circle"
                     src="./img/default-medium.png"/>';
    } else {
        echo '<img class="img-circle"
                     src="./img/'. $picture .'"/>';
    }
    echo '</div>
            <div class="inform"><div class = "defrow">
                    <label > Admin ID: </label> <span class = "lecID">' . $admin_id . '</span> </div>
                          <div class = "defrow"> <label> Official Name: </label> <span>' . $title . ' ' . $name . '</span></div>
                          <div class = "defrow"> <label> Email: </label> <span>' . $email . '</span></div>
                          <div class = "defrow"> <label> Phone: </label> <span>' . $phone . '</span></div>
                          <div class = "defrow"> <label> Department: </label> <span>' . $dept . '</span></div>
                          <div id ="edit" ><button id ="editprof" class ="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"> Edit Profile </button></div>'

    ?>

</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editprof"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <h2 class="text-center"> Edit Profile </h2>
            <hr>
            <div id="edit_prof_form">
                <form id="profile" action="php/edit_admin.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Official Name: </label>
                        <input class="form-control" placeholder="Name" type="name" name="name">
                    </div>
                    <div class="form-group">
                        <label>Phone: </label>
                        <input class="form-control" placeholder="Eg. 0********* (must begin with 0)" type="phone"
                               name="phone">
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Picture: </label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="4194304"/>
                        <input type="file" name="image" id="image">
                    </div>
                    <button class="btn btn-primary" id="save">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>



