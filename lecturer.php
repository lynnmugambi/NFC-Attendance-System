<?php
session_start();

$isIndex = 0;
if (!($_SESSION['type']) == 1 || !isset($_SESSION['type'])) {
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
    <title>Lecturer's Dashboard</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lecturer.js"></script>


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
            <li class="active"><a href="lecturer.php">Home</a></li>
            <li><a href="class.php">Classes</a></li>
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
    $m->get_Profile($_SESSION['username']);

    $lec_id = $_SESSION['lec_id'];
    $title = $_SESSION['title'];
    $dept = $_SESSION['dept'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = "";
    $username = $_SESSION['username'];
    $picture = $_SESSION['image'];
    if (!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
        $phone = "*Not Set*";
    } else {
        $phone = $_SESSION['phone'];
    }


    echo '<h2 class="con">Welcome, ' . $_SESSION['username'] . '.</h2>';
    echo '<div class="row">
        <div class="profile-header-container">
            <div class="profile-header-img">';
    if (!isset($_SESSION['image']) || empty($_SESSION['image'])) {
        echo '<img class="img-circle"
                     src="./img/default-medium.png"/>';
    } else {
        echo '<img class="img-circle"
                     src="./img/' . $picture . '"/>';
    }
    echo '</div>
            <div class="inform"><div class = "defrow">
                    <label > Lecturer ID: </label> <span class = "lecID">' . $lec_id . '</span> </div>
                          <div class = "defrow"> <label> Official Name: </label> <span>' . $title . ' ' . $name . '</span></div>
                          <div class = "defrow"> <label> Email: </label> <span>' . $email . '</span></div>
                          <div class = "defrow"> <label> Phone: </label> <span>' . $phone . '</span></div>
                          <div class = "defrow"> <label> Department: </label> <span>' . $dept . '</span></div>
                          <div id ="edit" ><button id ="editprof" class ="btn btn-primary" data-toggle="modal" data-target=".bs-modal"> Edit Profile </button></div>'

    ?>

</div>

<div class="modal fade bs-modal" tabindex="-1" role="dialog" aria-labelledby="editprof"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <h2 class="text-center"> Edit Profile </h2>
            <hr>
            <div id="edit_prof_form">
                <form id="profile" action="php/edit_profile.php" method="post" enctype="multipart/form-data">
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
<!--
<div class="alert"><span class="closebtn">&times;</span><strong>Danger!</strong> Indicates a dangerous or potentially
    negative action.
</div>

<script>
    // Get all elements with class="closebtn"
    var close = document.getElementsByClassName("closebtn");
    var i;

    // Loop through all close buttons
    for (i = 0; i < close.length; i++) {
        // When someone clicks on a close button
        close[i].onclick = function () {

            // Get the parent of <span class="closebtn"> (<div class="alert">)
            var div = this.parentElement;

            // Set the opacity of div to 0 (transparent)
            div.style.opacity = "0";

            // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
            setTimeout(function () {
                div.style.display = "none";
            }, 600);
        }
    }
</script>!-->

</body>
</html>
<!--<select class="form-control" name="year">
                        <?php // foreach (range(date('Y', time()), 1983) as $r) echo '<option>' . $r . '</option>'; ?>
                    </select>
                    <input class="form-control" name="code" placeholder="Code , Eg : COE-322">
                    <select class="form-control" name="section">
                        <option value="-1">Choose Section</option>
                        <?php // foreach (range(1, 3) as $r) echo '<option>' . $r . '</option>'; ?>
                    </select>
                    <select class="form-control" name="semester">
                        <option value="-1">Choose Semester</option>
                        <?php // foreach (range(1, 8) as $r) echo '<option>' . $r . '</option>'; ?>
                    </select>
                    <input class="form-control" name="start" placeholder="Starting Roll Number (Eg. 201/CO/12)">
                    <input class="form-control" name="end" placeholder="Ending Roll Number (Eg. 265/CO/12)">!-->