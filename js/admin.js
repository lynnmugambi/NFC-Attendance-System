function verify(type,input) {
    var regexes = {'sem':/^Y[1-4]-S(1|2)$/,'time':/^(1[0-2]|0?[1-9]):[0-5][0-9]\s(AM|PM)$/,"num":/^[0-9]+$/};//(1[012]|[1-9]):[0-5][0-9](\\s)?(?i)(am|pm)
    return ((input.match(regexes[type]) !== null));
}
$(document).ready(function () {
    searchClass()
    validateAssign()
    validateAttend()
    validateAssign2()
    changeAtt()
});

function searchClass() {
    $("#searchclass").submit(function () {
        var data = {};

        $("#searchclass").find("input").each(function (k, v) {
            if (!$(v).val().length) {
                $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                $('.alert').removeClass('hidden');
                return false;
            }
            data[$(v).attr('name')] = $(v).val();
        });
        $.ajax({
            url: 'php/search.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (r) {
                console.log(r);
                switch (r.error) {
                    case 'empty' :
                        $('.alert span').html('Please fill all the credentials !');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'not_found' :
                        $('.alert span').html('No such class found! Try adding class the to the system.');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-warning');
                        $('.alert').removeClass('hidden');
                        break
                    case 'found' :
                        $('.alert span').html('<img src="img/loading.gif"> Class Exists! Not Assigned to this user.');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').addClass('alert-success');
                        $('.alert').removeClass('hidden');
                        setTimeout(function () {
                            $('.ba-example-modal-lg').modal('hide');
                            $(".bc-example-modal-lg").html();
                            $('.bc-example-modal-lg').modal('show');
                        }, 2000);
                        break;
                    case 'none' :
                        $('.alert span').html('<img src="img/loading.gif"> <Strong>Success</strong>, record found and assigned to this user. ');
                        $('.alert').removeClass('hidden');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        setTimeout(function () {
                            $('.ba-example-modal-lg').modal('hide');
                            $(".bb-example-modal-lg").html();
                            $('.bb-example-modal-lg').modal('show');
                        }, 2000);
                        break;
                }
            }
        });
        return false
    });
}

function changeAtt() {
    $("#attendance").submit(function () {
        var data = {};

        $("#attendance").find("input").each(function (k, v) {
            if (!$(v).val().length) {
                $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                $('.alert').removeClass('hidden');
                return false;
            }
            data[$(v).attr('name')] = $(v).val();
        });
        $.ajax({
            url: 'php/search_att.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (r) {
                console.log(r);
                switch (r.error) {
                    case 'empty' :
                        $('.alert span').html('Please fill all the credentials !');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'non_exist' :
                        $('.alert span').html('No such class found! Try adding class the to the system.');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-warning');
                        $('.alert').removeClass('hidden');
                        break
                    case 'not_found' :
                        $('.alert span').html('This class does not have attendance data! Assign class and take attendance to create table data.');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-warning');
                        $('.alert').removeClass('hidden');
                        break
                    case 'found' :
                        $('.alert span').html('Class attendance data exists! But student is not assigned to this class.');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-warning');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'none' :
                        $('.alert span').html('<img src="img/loading.gif"> <Strong>Success</strong>, record found and assigned to this user. ');
                        $('.alert').removeClass('hidden');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        setTimeout(function () {
                            $('.be-example-modal-lg').modal('hide');
                            $(".bf-example-modal-lg").html();
                            $('.bf-example-modal-lg').modal('show');
                        }, 2000);
                        break;
                }
            }
        });
        return false
    });
}

function validateAssign(){
    $("#comassign").submit(function () {
        var data = {};
        var isEmpty = 0;
        $("#comassign input").each(function (k, v) {
            if (!$(v).val().length) {
                $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                $('.alert').removeClass('alert-danger');
                $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-warning');
                $('.alert').removeClass('hidden');
                isEmpty++;
                return false;
            }
            data[$(v).attr('name')] = $(v).val();
        });
        if (isEmpty) return false;
        if(!verify('sem',data.Semester)) {
            $('.alert span').html('Invalid Format for Semester Field');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        if (!(data.Day == "Monday" || data.Day == "Tuesday" || data.Day == "Wednesday" || data.Day == "Thursday" ||
            data.Day == "Friday")) {
            $('.alert span').html('Please choose a day of the week between Monday and Friday!');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        if (!(data.Duration == 1 || data.Duration == 2 || data.Duration == 3)) {
            $('.alert span').html('A class can only be 1,2 or 3 hours long!');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }

        if(!verify('time',data.Start_Time)) {
            $('.alert span').html('Invalid Format for Start Time Field');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        if(!verify('time',data.End_Time)) {
            $('.alert span').html('Invalid Format for End Time Field');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        $.ajax({
            url: 'php/assign.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (r) {
                console.log(r);
                switch (r.error) {
                    case 'none' :
                        $('.alert span').html('<img src="img/loading.gif"> <Strong>Success</strong>, record saved. ');
                        $('.alert').removeClass('hidden');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        setTimeout(function () {
                            $('.bb-example-modal-lg').modal('hide');
                            window.location="";
                        }, 2000);
                        break;
                }
            }
        });
        return false
    });

}

function validateAttend(){
    $("#comattend").submit(function () {
        var data = {};
        var isEmpty = 0;
        $("#comattend input").each(function (k, v) {
            if (!$(v).val().length) {
                $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                $('.alert').removeClass('alert-danger');
                $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-warning');
                $('.alert').removeClass('hidden');
                isEmpty++;
                return false;
            }
            data[$(v).attr('name')] = $(v).val();
        });
        if (isEmpty) return false;
        if(!verify('num',data.Attended)) {
            $('.alert span').html('Invalid Format for Classes Attended Field! Numbers only!');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }

        $.ajax({
            url: 'php/assign_att.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (r) {
                console.log(r);
                switch (r.error) {
                    case 'none' :
                        $('.alert span').html('<img src="img/loading.gif"> <Strong>Success</strong>, record saved. ');
                        $('.alert').removeClass('hidden');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        setTimeout(function () {
                            $('.bf-example-modal-lg').modal('hide');
                            window.location="/fyp/stud_tools.php";
                        }, 1000);
                        break;
                }
            }
        });
        return false
    });

}

function validateAssign2(){
    $("#incomassign").submit(function () {
        var data = {};
        var isEmpty = 0;
        $("#incomassign input").each(function (k, v) {
            if (!$(v).val().length) {
                $('.alert span').html('Please enter <strong>' + $(v).attr('name') + '</strong> !');
                $('.alert').removeClass('alert-danger');
                $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-warning');
                $('.alert').removeClass('hidden');
                isEmpty++;
                return false;
            }
            data[$(v).attr('name')] = $(v).val();
        });
        if (isEmpty) return false;
        if(!verify('sem',data.Semester)) {
            $('.alert span').html('Invalid Format for Semester Field');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        if (!(data.Day == "Monday" || data.Day == "Tuesday" || data.Day == "Wednesday" || data.Day == "Thursday" ||
                data.Day == "Friday")) {
            $('.alert span').html('Please choose a day of the week between Monday and Friday!');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        if (!(data.Duration == 1 || data.Duration == 2 || data.Duration == 3)) {
            $('.alert span').html('A class can only be 1, 2 or 3 hours long!');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }

        if(!verify('time',data.Start_Time)) {
            $('.alert span').html('Invalid Format for Start Time Field');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        if(!verify('time',data.End_Time)) {
            $('.alert span').html('Invalid Format for End Time Field');
            $('.alert').removeClass('alert-danger');
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-warning');
            $('.alert').removeClass('hidden');
            return false;
        }
        $.ajax({
            url: 'php/assign.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (r) {
                console.log(r);
                switch (r.error) {
                    case 'empty' :
                        $('.alert span').html('Please fill all the credentials !');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert').removeClass('hidden');
                        break;
                    case 'none' :
                        $('.alert span').html('<img src="img/loading.gif"> <Strong>Success</strong>, record saved. ');
                        $('.alert').removeClass('hidden');
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        setTimeout(function () {
                            $('.bc-example-modal-lg').modal('hide');
                            window.location="";
                        }, 1000);
                        break;
                }
            }
        });
        return false
    });

}

