<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>::Admin Panel::</title>
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description"
          content=""/>
    <meta name="keywords"
          content="">
    <meta name="author" content="etech"/>

    <link rel="icon" href="/files/assets/images/favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <link id="bsdp-css" href="/files/bower_components/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet">
<style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #FFFFFF !important;
        }

        .select2-container .select2-selection--single {
            height: 46px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="/files/bower_components/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="/files/assets/pages/waves/css/waves.min.css" type="text/css" media="all">

    <link rel="stylesheet" type="text/css" href="/files/assets/icon/feather/css/feather.css">

    <link rel="stylesheet" type="text/css" href="/files/assets/css/font-awesome-n.min.css">

    <link rel="stylesheet" href="/files/bower_components/chartist/css/chartist.css" type="text/css" media="all">

    <link rel="stylesheet" type="text/css" href="/files/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/css/widget.css">
    <link rel="stylesheet" type="text/css" href="/files/bower_components/animate.css/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/notification/notification.css">
    <link rel="stylesheet" type="text/css" href="/files/bower_components/sweetalert/css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css">

    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css"/>

    {{-- <link rel="stylesheet" type="text/css" href="/files/bower_components/datedropper/css/datedropper.min.css"/> --}}

    <link rel="stylesheet" type="text/css" href="/files/assets/icon/glyph/css/bootstrap.min.css">
    @yield('headerScripts')
    <style>
        .thead-dark th {
            color: #fff;
            background-color: #000;
            border-color: #fff;
            font-weight: 800;
            width:50%;
        }
        .thead-dark td {
            background-color: #d3d3d3dd;
            font-weight: 700;
            border-color: #fff;
        }
    </style>
</head>
<body onload="Quick_Load()">

<div class="loader-bg1">
    <div class="loader-bar1"></div>
</div>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a href="/home">
                        <img class="img-fluid" src="/files/assets/images/logo.png" alt="Theme-Logo"/>
                    </a>
                    <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="feather icon-menu icon-toggle-right"></i>
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="feather icon-more-horizontal"></i>
                    </a>
                </div>
                <div class="navbar-container container-fluid">
                    <ul class="nav-right">
                        <li class="header-notification">
<div class="dropdown-primary dropdown">
<div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
<i class="feather icon-plus-circle"></i> Quick Book
</div>
</div>
</li>
                        <li class="user-profile header-notification">
                            <div class="dropdown-primary dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/files/assets/images/avatar-4.jpg" class="img-radius"
                                         alt="User-Profile-Image">
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <ul class="show-notification profile-notification dropdown-menu"
                                    data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <li>
                                        <a href="/Users/editUser/{{ Auth::user()->id }}">
                                            <i class="feather icon-user"></i> Profile
                                        </a>
                                    </li>

                                    <li>
                                        <a href="/logout">
                                            <i class="feather icon-log-out"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div id="sidebar" class="users p-chat-user showChat" style="width: 350px;">
<div class="had-container">
<div class="p-fixed users-main"  style="width: 350px;">
<div class="user-box">
<div class="chat-search-box" style="padding: 10px;">
<a class="back_friendlist">
<i class="feather icon-x"></i>
</a>
{{-- <div class="right-icon-control">
<div class="input-group input-group-button">
<input type="text" id="search-friends" name="footer-email" class="form-control" placeholder="Search Friend">
<div class="input-group-append">
<button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-search"></i></button>
</div>
</div>
</div> --}}
</div>
<div class="main-friend-list" style="padding: 10px;">

{{-- <form name="frmQickBook" id="frmQickBook" method="POST" action="/appointments/QuickAppointment"> --}}
    <div class="form-group">
        <div class="row">
        <label class="col-md-12 col-form-label" for="Quick_select_employee">Select Doctor</label>
    </div>
    <div class="row">
        <div class="col-md-12">
            <select class="form-control select2QBox" id="Quick_select_employee" name="Quick_select_employee" onchange="Quick_loadCustomers()" style="width: 100%;">
                <option value="0">Select Doctor</option>
            </select>
        </div>
    </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12">

            <input type="checkbox" name="chkQuickNewPatient" id="chkQuickNewPatient" value="1" onchange="newPatientToggle()"> New Patient
        </div>
    </div>

    <div class="form-group" id="QuickOldPatient">
        <div class="row">
            <label class="col-md-12 col-form-label" for="Quick_select_patient">Select Patient</label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <select class="form-control select2QBox" id="Quick_select_patient" name="Quick_select_patient" style="width: 100%;">
                    <option value="0">Select Patient</option>
                </select>
            </div>
        </div>
    </div>


    <div id="QuickNewPatient" style="display: none;">
        <div class="form-group">
            <div class="row">
                <label class="col-md-12 col-form-label" for="Quick_enter_patient">Patient Name</label>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="form-control" value="" id="Quick_enter_patient" name="Quick_enter_patient" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-12 col-form-label" for="Quick_enter_patientMobile">Patient Mobile</label>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="form-control phoneNumberInput" value="" id="Quick_enter_patientMobile" name="Quick_enter_patientMobile" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-12 col-form-label" for="Quick_enter_patientCase">Case ID</label>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" value="" class="form-control" id="Quick_enter_patientCase" name="Quick_enter_patientCase" />
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-md-12 col-form-label" for="Quick_dateFrom">Date</label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="Quick_dateFrom" id="Quick_dateFrom" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <label class="col-md-12 col-form-label" for="Quick_timeFrom">Time</label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="Quick_timeFrom" id="Quick_timeFrom" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12">
            <input type="checkbox" name="Quick_lblOnline" id="Quick_lblOnline" value="1" /> Online Appointment
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12"><input type="radio" name="Quick_lblCaseType" id="Quick_regularCase" value="Regular" checked /> Regular</div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4"><input type="radio" name="Quick_lblCaseType" id="Quick_newCase" value="NC" /> New Case</div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4"><input type="radio" name="Quick_lblCaseType" id="Quick_retake" value="RETAKE" /> Retake</div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12">
            <input type="button" name="quickSubmit" id="quickSubmit" class="btn btn-primary" value="Book Appointment" onclick="validateQuickBook()" />
        </div>
    </div>

    <!-- <div class="form-group row msgbtn" style="display:none;">
        <div class="col-sm-12">
            <textarea name="whatsappmsg" id="whatsappmsg" class="form-control">WhatsApp Message here</textarea>
            <br>
            <a href="#" id="whatsappbtn" class="btn btn-sm btn-success" target="_blank">Send</a>
        </div>
    </div> -->

{{-- </form> --}}


{{-- <div class="media userlist-box waves-effect waves-light" data-id="5" data-status="offline" data-username="Suzen">
<a class="media-left" href="#!">
<img class="media-object img-radius" src="../files/assets/images/avatar-2.jpg" alt="Generic placeholder image">
<div class="live-status bg-default"></div>
</a>
<div class="media-body">
<div class="f-13 chat-header">Suzen<small class="d-block text-muted">15 min ago</small></div>
</div>
</div> --}}
</div>
</div>
</div>
</div>
</div>




        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="nav-list">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigation-label">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu active pcoded-trigger">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Appointments</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ (request()->is('home')) ? 'active' : '' }}">
                                            <a href="/home" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Dashboard</span>
                                            </a>
                                        </li>

                                        <li class="{{ (request()->segment(1) == 'appointments') ? 'active' : '' }}">
                                            <a href="/appointments/manageAppointment" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Book Appointment</span>
                                            </a>
                                        </li>

                                        <li class="{{ (request()->segment(1) == 'reports') ? 'active' : '' }}">
                                            <a href="#" id="manageAppointTable" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Manage Appointments</span>
                                            </a>
                                        </li>

                                        {{--<li class="{{ (request()->segment(1) == 'letters') ? 'active' : '' }}">
                                            <a href="/letters/myAppointments" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Generate Letters</span>
                                            </a>
                                        </li>--}}

                                        <li class="{{ (request()->segment(1) == 'customers') ? 'active' : '' }}">
                                            <a href="/customers/getCustomersList" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Patient Management</span>
                                            </a>
                                        </li>
                                        @if(Auth::user()->userType=='Admin')
                                        <li class="{{ (request()->segment(1) == 'Users') ? 'active' : '' }}">
                                            <a href="/Users/getUsersList" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Doctor Management</span>
                                            </a>
                                        </li>

                                            <li class="{{ (request()->segment(1) == 'dbmanage') ? 'active' : '' }}">
                                                <a href="/dbmanage/createBackup" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext">Create Backup</span>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="{{ (request()->segment(1) == 'appointmentReports') ? 'active' : '' }}">
                                            <a href="/appointmentReports/indexClear" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Summary Reports</span>
                                            </a>
                                        </li>
                                        <li class="{{ (request()->segment(1) == 'feeReports') ? 'active' : '' }}">
                                            <a href="/feeReports/feeReportClear" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Fee Reports</span>
                                            </a>
                                        </li>
                                        <li class="{{ (request()->segment(1) == 'templates') ? 'active' : '' }}">
                                            <a href="/templates/MyTemplates" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Settings</span>
                                            </a>
                                        </li>
                                        <li class="{{ (request()->segment(1) == 'archive') ? 'active' : '' }}">
                                            <a href="/archive" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Archive</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>
                @yield('contents')
            </div>
        </div>
    </div>
</div>


<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade
        <br/>to any of the following web browsers to access this website.
    </p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="/files/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="/files/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="/files/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="/files/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="/files/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<script type="text/javascript" src="/files/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="/files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/files/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="/files/bower_components/bootstrap/js/bootstrap.min.js"></script>

<script src="/files/assets/pages/waves/js/waves.min.js" type="text/javascript"></script>

<script type="text/javascript" src="/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<script src="/files/assets/pages/chart/float/jquery.flot.js" type="text/javascript"></script>
<script src="/files/assets/pages/chart/float/jquery.flot.categories.js" type="text/javascript"></script>
<script src="/files/assets/pages/chart/float/curvedLines.js" type="text/javascript"></script>
<script src="/files/assets/pages/chart/float/jquery.flot.tooltip.min.js" type="text/javascript"></script>

<script src="/files/assets/js/pcoded.min.js" type="text/javascript"></script>
<script src="/files/assets/js/vertical/vertical-layout.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/files/assets/js/bootstrap-growl.min.js"></script>

<script type="text/javascript" src="/files/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="/files/bower_components/sweetalert/js/sweetalert.min.js"></script>

<script type="text/javascript" src="/files/assets/js/modalEffects.js"></script>
 <!-- Select2 Files -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.1/sweetalert.min.js"></script>--}}
<script src="/files/bower_components/datepicker/bootstrap-datepicker.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script> -->
<script>
    function Quick_Load() {
        $('.select2QBox').select2();

        var fullDate = new Date();
            //console.log(fullDate);
            //Thu May 19 2011 17:25:38 GMT+1000 {}

            //convert month to 2 digits
           // console.log('{{Carbon\Carbon::now()->format("d-m-Y")}}');
           // var twoDigitMonth = ((fullDate.getMonth()+1) >9)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);

           // var currentDate = fullDate.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
            //console.log(currentDate);

            $("#Quick_dateFrom").val('{{Carbon\Carbon::now()->format("d-m-Y")}}');
            /* $("#Quick_dateFrom").dateDropper({
                dropWidth: 200,
                format: "d-m-Y",
                large: true,
                largeDefault: true
            }); */
             $('#Quick_dateFrom').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: true
            });

            $('#Quick_timeFrom').datetimepicker({
                    format: 'HH:mm'
                });

                //Load Doctors
                $('#Quick_select_employee').empty();
                $("#Quick_select_employee").append("<option value='0'>Loading...</option>");
                // AJAX request
            $.ajax({
            url: '/getDoctors',
            type: 'get',
            dataType: 'json',
            success: function(response){
                $('#Quick_select_employee').empty();
                $("#Quick_select_employee").append("<option value='0'>Select Doctor</option>");
                var len = 0;
                if(response != null){
                len = response.length;
                }
                if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){

                    var id = response[i].id;
                    var name = response[i].name;

                    var option = "<option value='"+id+"'>"+name+"</option>";

                    $("#Quick_select_employee").append(option);
                }
                $("#Quick_select_employee").val("1");
                Quick_loadCustomers();
                }

            }
            });
    }

    $("#manageAppointTable").click(function(){
        localStorage.setItem('dateFrom', '{{Carbon\Carbon::now()->format("d-m-Y")}}');
        localStorage.setItem('dateTo', '{{Carbon\Carbon::now()->format("d-m-Y")}}');
        window.location.href = "/reports/SummarySheetclear";
    });

    $('.phoneNumberInput').on('paste', function () {
        // Get the clipboard data
        var clipboardData = event.clipboardData || window.clipboardData;
        var pastedData = clipboardData.getData('text');

        // Remove white spaces from the pasted phone number
        var phoneNumberWithoutSpaces = pastedData.replace(/\s/g, '');

        // Set the input field value to the phone number without spaces
        $(this).val(phoneNumberWithoutSpaces);

        // Prevent the default paste behavior
        return false;
      });

    

    function Quick_loadCustomers() {
        if($('#Quick_select_employee').val()!="0" || $('#Quick_select_employee').val()!="")
        {
            $('#Quick_select_patient').empty();
            $("#Quick_select_patient").append("<option value='0'>Loading...</option>");
            // AJAX request
            $.ajax({
            url: '/loadCustomers/'+$('#Quick_select_employee').val(),
            type: 'get',
            dataType: 'json',
            success: function(response){
                $('#Quick_select_patient').empty();
                $("#Quick_select_patient").append("<option value='0'>Select Patient</option>");
                var len = 0;
                if(response != null){
                len = response.length;
                }
                if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){

                    var id = response[i].id;
                    var name = response[i].caseId+" | "+response[i].name+" | "+response[i].mobile;

                    var option = "<option value='"+id+"'>"+name+"</option>";

                    $("#Quick_select_patient").append(option);
                }
                }

            }
            });
        }
    }

    /* $("#Quick_lblOnline").click(function(){
        if($("#Quick_lblOnline").is(':checked')) {
            $('.msgbtn').show();
            messageforonlineconsultation();
        } 
    }); */

    /* $("#whatsappmsg").keyup(function(){
        messageforonlineconsultation();
    }); */

    function messageforonlineconsultation() {
        var message = "Your Homeopathy WhatsApp/Zoom Online Consultation appointment has been Confirmed for #FIRST#  Case ID# #CASE# #TIME#*. Please be on time. For new/first consult please bring your existing reports if any. For *Follow up appointment bring your existing Homeopathy medicines even if empty. Kindly read our cancellation policy in the link below. https://drmanishal.com/cancellation-policy *Please confirm. ok?*.";

        if($("#chkQuickNewPatient").is(':checked')) {
            let mobile = $("#Quick_enter_patientMobile").val();
            if(mobile.length > 0) {
                // Define values to replace the placeholders
                let replacementValues = {
                    '#FIRST#': $('#Quick_enter_patient').val(),
                    '#CASE#': $('#Quick_enter_patientCase').val(),
                    '#TIME#': $('#Quick_timeFrom').val()
                };

                // Replace the placeholders with actual values
                $.each(replacementValues, function (key, value) {
                    message = message.replace(key, value);
                });

                return message;
                /* let whatsapp = $("#whatsappmsg").val(message);
                    
                    $("#whatsappbtn").attr("href", "https://api.whatsapp.com/send?phone="+mobile+"&text="+message); */
            }
        } else {
            let data = $("#Quick_select_patient option:selected").text();
            const custdata = data.split("~");

            // Define values to replace the placeholders
            let replacementValues = {
                '#FIRST#': custdata[1],
                '#CASE#': custdata[0],
                '#TIME#': $('#Quick_timeFrom').val()
            };

            // Replace the placeholders with actual values
            $.each(replacementValues, function (key, value) {
                message = message.replace(key, value);
            });

            return message;

            /* let whatsapp = $("#whatsappmsg").val(message);
                
            $("#whatsappbtn").attr("href", "https://api.whatsapp.com/send?phone="+custdata[2]+"&text="+message); */
        }
    }

    function validateQuickBook() {
        var selectedDateParts=$('#Quick_dateFrom').val().split("-");
            var selectedDate=new Date(selectedDateParts[2],selectedDateParts[1]-1,selectedDateParts[0]);
            var today=new Date();
            today.setHours(0);
            today.setMinutes(0);
            today.setSeconds(0);
            today.setMilliseconds(0);
            if($('#Quick_select_employee').val()=="0")
                {
                    swal({
                        title: "Error",
                        text: "Please Select Doctor!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
                     return false;
                }
            else if(!$('#chkQuickNewPatient').is(":checked") && $('#Quick_select_patient').val()=="0")
                {
                    swal({
                        title: "Error",
                        text: "Please Select Patient!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
                     return false;
                }
                else if($('#Quick_timeFrom').val()=='')
                {
                    swal({
                        title: "Error",
                        text: "Please choose appointment time!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
                     return false;
                }
                else if($('#chkQuickNewPatient').is(":checked") && ($('#Quick_enter_patient').val()=='' || $('#Quick_enter_patientMobile').val()=='' || $('#Quick_enter_patientCase').val()==''))
                {

                    swal({
                        title: "Error",
                        text: "Patient Name,Mobile Number and Case Id are required!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
                     return false;
                }
                else if(today>selectedDate)
                {
                    //TODO ask password and save appointment to the table instead of google calendar
                    checkQuickPassword();
                     return true;
                }
                else
                {
                    sendQuickAjaxRequest();
                    return true;
                }
    }

    function sendQuickAjaxRequest() {

         $('#quickSubmit').prop('disabled', true);
         $('#quickSubmit').prop('value', 'Processing...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            jQuery.ajax({
                url: "{{ url('/appointments/QuickAppointment') }}",
                method: 'post',
                data: {
                    Quick_select_employee: $( "#Quick_select_employee" ).val(),
                    Quick_select_patient: $( "#Quick_select_patient" ).val(),
                    Quick_dateFrom:$( "#Quick_dateFrom" ).val(),
                    Quick_timeFrom:$( "#Quick_timeFrom" ).val(),
                    Quick_lblOnline:$('#Quick_lblOnline').is(':checked')?"1":"0",
                    Quick_lblCaseType:$('input[name="Quick_lblCaseType"]:checked').val(),
                    chkQuickNewPatient:$('#chkQuickNewPatient').is(":checked")?"1":"0",
                    Quick_enter_patient:$( "#Quick_enter_patient" ).val(),
                    Quick_enter_patientMobile:$( "#Quick_enter_patientMobile" ).val(),
                    Quick_enter_patientCase:$( "#Quick_enter_patientCase" ).val(),
                },
                success: function (result) {
                    console.log(result);
                    swal({
                            title: "Saved",
                            text: "Appointment booked do you want to send folloup reminder?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, Send Reminder!",
                            cancelButtonText: "No need to Remind!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function(isConfirm) {
                        if (isConfirm) {
                            sendQuickWhatsappMsg(result.whatsappMsg,result.followupAppointment);
                        }
                        });
                    /* swal({
                            title: "Success",
                            text: "Appointment Booked successfully!",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        }); */
                        $('#quickSubmit').prop('disabled', false);
                        $('#quickSubmit').prop('value', 'Book Appointment');
                },
                error: function (jqXHR, exception) {
                    console.log(jqXHR);
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].\n' + jqXHR.responseText;
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    swal({
                        title: "Error",
                        text: "Error: "+msg,
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                    $('#quickSubmit').prop('disabled', false);
                        $('#quickSubmit').prop('value', 'Book Appointment');
                    // notify('top', 'center', 'fa fa-user-times', 'danger', 'animated flipInX', 'animated flipOutX', msg);
                }
            });

        }

        function sendQuickWhatsappMsg(msg,mobileNumbers) {

            if(mobileNumbers.startsWith("+"))
            {
                mobileNumbers=mobileNumbers.replace("+", "");
                console.log(mobileNumbers);
            }
            else
            {
                mobileNumbers= {{Auth::user()->default_Country_Code}}+mobileNumbers;
            }
            mobileNumbers=mobileNumbers.replace(" ","");
            window.open("https://api.whatsapp.com/send?phone="+mobileNumbers+"&text="+msg);
            //alert(decodeURIComponent((msg+'').replace(/\+/g, '%20')));
        }

        function newPatientToggle()
        {
            if($('#chkQuickNewPatient').is(":checked"))
            {
                $("#Quick_newCase").prop("checked", true);
                $('#QuickNewPatient').show();
                $('#QuickOldPatient').hide();
                $('#Quick_enter_patientCase').val('NC');
            }
            else
            {
                $("#Quick_regularCase").prop("checked", true);
                $('#QuickNewPatient').hide();
                $('#QuickOldPatient').show();
                $('#Quick_enter_patientCase').val('');
            }
        }

        function checkQuickPassword() {
            swal({
                title: "Enter Password",
                text: "Please Enter Your Password to save past appointment",
                type: "input",
                inputType: "password",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Please Enter Your Password!");
                    return false
                }
                checkQuickPasswordAjax(inputValue);
            });
        }

        function checkQuickPasswordAjax(inputValue) {
            var lblOnline=0;
            var newPatient=0;
            if($('#Quick_lblOnline').is(':checked'))
            {
                lblOnline=1;
            }
            if($('#chkQuickNewPatient').is(':checked'))
            {
                newPatient=1;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            jQuery.ajax({
                url: "{{ url('/appointments/BookPastAppointment') }}",
                method: 'post',
                data: {
                    inpass: inputValue,
                    Quick_select_patient: $('#Quick_select_patient').val(),
                    Quick_select_employee: $('#Quick_select_employee').val(),
                    chkQuickNewPatient: newPatient,
                    Quick_enter_patient: $('#Quick_enter_patient').val(),
                    Quick_enter_patientMobile: $('#Quick_enter_patientMobile').val(),
                    Quick_enter_patientCase: $('#Quick_enter_patientCase').val(),
                    Quick_dateFrom: $('#Quick_dateFrom').val(),
                    Quick_timeFrom: $('#Quick_timeFrom').val(),
                    Quick_lblOnline: lblOnline,
                    Quick_lblCaseType: $('input[name="Quick_lblCaseType"]:checked').val(),
                },
                success: function (result) {
                    swal({
                        title: "Saved",
                        text: "appointment Saved Successfully",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                },
                error: function (jqXHR, exception) {
                    console.log(jqXHR);
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 400) {
                        msg = 'Password Not Matched';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    swal({
                        title: "Error",
                        text: "Error: "+msg,
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                    // notify('top', 'center', 'fa fa-user-times', 'danger', 'animated flipInX', 'animated flipOutX', msg);
                }
            });

        }
</script>
<script type="text/javascript" src="/files/assets/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>


    {{-- <script type="text/javascript" src="/files/bower_components/datedropper/datedropper.pro.min.js"></script> --}}
@yield('scripts')
</body>
</html>
