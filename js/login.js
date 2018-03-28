function verify(type,input) {
    var regexes = {'email':/^([\S]+)@([\S]+)\.([\S]+)$/,'phone':/^[0-9]{10}$/,'code':/^([a-zA-Z]{3})\-([0-9]{3})$/,'roll':/^([0-9]{3})\/([a-zA-z]{2})\/([0-9]{2})$/,'name':/^[a-zA-Z \']+$/,'num':/^[0-9]+$/};
    return ((input.match(regexes[type]) == null)? false:true);
}
$(document).ready(function () {
    processLogin();
   //processSignup();
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
                        $('.alert span').html('Please fill in all the credentials!');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'not_found' :
                        $('.alert span').html('No such user found! Contact Administrator for sign up.');
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
function processSignup() {
    $("#signup").submit(function() {
        var data = {};
        var isEmpty = 0;
        $("#signup input").each(function(k,v) {
            if(!$(v).val().length) {
                $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                $('.alert').removeClass('hidden');
                isEmpty++;
                return false;
            }
            data[$(v).attr('name')] = $(v).val();
        });
        if(isEmpty) return false;
        if($("#signup input[name=password]").val() != $("#signup input[name=password2]").val()) {
            $('.alert span').html('Password don\'t match!');
            $('.alert').removeClass('hidden');
            return false;
        }
        if($("#signup input[name=password]").val().length < 6) {
            $('.alert span').html('Password is smaller than 6 characters!');
            $('.alert').removeClass('hidden');
            return false;
        }
        if(!verify('phone',data.phone)) {
            $('.alert span').html('Invalid Phone');
            $('.alert').removeClass('hidden');
            return false;
        }
        if(!verify('email',data.email)) {
            $('.alert span').html('Invalid Email');
            $('.alert').removeClass('hidden');
            return false;
        }
        if(!verify('name',data.name)) {
            $('.alert span').html('Invalid Name');
            $('.alert').removeClass('hidden');
            return false;
        }
        $.ajax({
            url : 'php/process_signup.php',
            type : 'post',
            data : data,
            dataType : 'json',
            success : function(r) {
                console.log(r);
                switch(r.error) {
                    case 'email' :
                        $('.alert span').html('Invalid Email');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'phone' :
                        $('.alert span').html('Invalid Phone');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'name' :
                        $('.alert span').html('Invalid Name');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'empty' :
                        $('.alert span').html('Fill all the details');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'mismatch' :
                        $('.alert span').html('Password don\'t match');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'small' :
                        $('.alert span').html('Password is too small! It should be at least 6 characters long');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'exists' :
                        $('.alert span').html('There already exists an account with that email ID. Try logging in.');
                        $('.alert').removeClass('hidden');
                        $("form#login input[name=email]").val($("form#signup input[name=email]").val());
                        $("form#login input[name=email]").focus();
                        break;
                    case 'db_error' :
                        $('.alert span').html('We are facing troubles at our server side !');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'none' :
                        $('.alert span').html('You have successfully signed up! Login using the same credentials now.');
                        $("form#login input[name=email]").val($("form#signup input[name=email]").val());
                        $("form#login input[name=email]").focus();
                        $('.alert').removeClass('hidden');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').addClass('alert-success');
                        break;
                }
            }
        });
        return false;
    });
}