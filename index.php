<?php
session_start();

$isIndex = 1;
if (isset($_SESSION['type'])) {
    if (array_key_exists('type', $_SESSION) && ($_SESSION['type']) == 1) {
        header('Location: lecturer.php');
    } elseif (array_key_exists('type', $_SESSION) && ($_SESSION['type']) == 0) {
        header('Location: admin.php');
    }
} else {
    if (!$isIndex) header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css"/>
    <title>Student Attendance</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script ></script>
    <script>
        function verify(type,input) {
            var regexes = {'email':/^([\S]+)@([\S]+)\.([\S]+)$/,'phone':/^[0-9]{10}$/,'code':/^([a-zA-Z]{3})\-([0-9]{3})$/,'roll':/^([0-9]{3})\/([a-zA-z]{2})\/([0-9]{2})$/,'name':/^[a-zA-Z \']+$/,'num':/^[0-9]+$/};
            return ((input.match(regexes[type]) == null)? false:true);
        }
        $(document).ready(function () {
            processLogin();
        });
        function processLogin() {
            $("#login").submit(function() {
                console.log("Here");
                var data = {};
                $("#login").find("input").each(function(k,v) {
                    if(!$(v).val().length) {
                        $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                        $('.alert').removeClass('hidden');
                        return false;
                    }
                    data[$(v).attr('name')] = $(v).val();
                });
                $.ajax({
                    url : 'php/process_login.php',
                    type : 'post',
                    data : data,
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
                                //$("form#signup input[name=email]").val($("form#login input[name=email]").val());
                                //$("form#signup input[name=email]").focus();
                                break;
                            case 'email' :
                                $('.alert span').html('Invalid Email');
                                $('.alert').removeClass('hidden');
                                break;
                            case 'incorrect' :
                                $('.alert span').html('Incorrect Password!');
                                $('.alert').removeClass('hidden');
                                $('.alert').removeClass('alert-warning');
                                $('.alert').addClass('alert-danger');
                                break;
                            case 'none' :
                                $('.alert span').html('<img src="img/loading.gif"> <Strong>Welcome</strong>, you are being logged in ');
                                $('.alert').removeClass('hidden');
                                $('.alert').removeClass('alert-warning');
                                $('.alert').removeClass('alert-danger');
                                $('.alert').addClass('alert-success');
                                setTimeout(function(){
                                    window.location="";
                                }, 2000);
                                break;
                        }
                    }
                });
                return false;
            });
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
    </div>
</div>
<h2 class="log">For University Staff</h2>
<div class="log">
    <div class="alert alert-warning hidden">
        <span></span>
        <button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
    </div>

    <table class=" table table-bordered table-striped">
        <thead>
        <tr>
            <th>Please enter your login credentials below:</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <form id="login">
                    <div class="input-group spacing">
                        <span class="input-group-addon ">@</span>
                        <input class="form-control" placeholder="Email" type="email" name="email">
                    </div>
                    <div class="input-group spacing">
                        <span class="input-group-addon "><i class="glyphicon glyphicon-lock"></i></span>
                        <input class="form-control" placeholder="Password" type="password" name="password">
                    </div>
                    <button class="btn btn-primary pull-right">Login</button>
                </form>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>


