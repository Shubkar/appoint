@extends('layouts.app')
@section('headerScripts')

 <link rel="stylesheet" type="text/css" href="/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css">

    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css"/>

    <link rel="stylesheet" type="text/css" href="/files/bower_components/datedropper/css/datedropper.min.css"/>

    <link rel="stylesheet" type="text/css" href="/files/assets/icon/glyph/css/bootstrap.min.css">

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

           
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #FFFFFF !important;
        }

        .select2-container .select2-selection--single {
            height: 46px !important;
        }
    </style>
    <style>
        .fixedHeader-floating
        {
            top:63px !important;
            z-index:9999;
        }
    </style>
@endsection
@section('contents')
    <div class="pcoded-content">

        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Followup Appointment</h5>
                            <span>Setup Followup</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Followup Appointment</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-sm-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Followup Appointment</h5>
                                    </div>
                                    <div class="card-block">
                                        <form name="frm_newAppointment" id="frm_newAppointment" method="POST" action="/appointments/setupFolloup">
                                        <div class="form-group row">
                                            <label style="text-align: right;" class="col-md-2 col-sm-6 col-xs-6 col-form-label" for="select_employee">Doctor Name</label>
                                            <label class="col-md-4 col-sm-6 col-xs-6 col-form-label">{{$doctor->name}}</label>

                                            <label style="text-align: right;" class="col-md-2 col-sm-6 col-xs-6 col-form-label" for="select_patient">Patient Name</label>
                                            
                                              <label class="col-md-4 col-sm-6 col-xs-6 col-form-label">{{$appointment->customerName}}</label>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <label style="text-align: right;" class="col-md-2 col-sm-6 col-xs-6 col-form-label">Case ID</label>
                                            
                                            <label class="col-md-4 col-sm-6 col-xs-6 col-form-label">{{$appointment->caseId}}</label>
                                           
                                            

                                            <label style="text-align: right;" class="col-md-2 col-sm-6 col-xs-6 col-form-label">Mobile No</label>
                                            
                                              <label class="col-md-4 col-sm-6 col-xs-6 col-form-label">{{$appointment->mobileNumber}}</label>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-sm-6 col-xs-6 col-form-label" style="text-align: right;">Date</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                                        <input type="text" name="dateFrom" id="dateFrom"
                                                               class="form-control" required>
                                                    </div>

                                                    <label class="col-md-2 col-sm-6 col-xs-6 col-form-label" for="timeFrom" style="text-align: right;">Time</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                                        <input type="text" name="timeFrom" id="timeFrom"
                                                               class="form-control" required>
                                                    </div>

                                                    
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 col-sm-6 col-xs-6">
                                                <input type="checkbox" name="lblOnline" id="lblOnline" value="1" onchange="isOnline()" /> Online Appointment
                                            </div>
                                                   <div class="col-md-10 col-sm-6 col-xs-6" id="onlineMeetingDiv" style="display: none;">
                                                       <div class="row">
                                                           <div class="col-md-4 col-sm-6 col-xs-6">
                                                        <input type="text" name="meetingID" id="meetingID"
                                                               class="form-control" placeholder="Meeting ID">
                                                    </div>

                                                     <div class="col-md-4 col-sm-6 col-xs-6">
                                                        <input type="text" name="modPasscode" id="modPasscode"
                                                               class="form-control" placeholder="Mod Passcode">
                                                    </div>

                                                     <div class="col-md-4 col-sm-6 col-xs-6">
                                                        <input type="text" name="participantsCode" id="participantsCode"
                                                               class="form-control" placeholder="Participants Code">
                                                    </div>

                                                       </div>
                                                   </div>
                                                   
                                                    

                                                   

                                                    
                                        </div>

                                        <div class="form-group row">
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <button type="submit" onclick="return validate_booking()"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Book Appointment
                                                </button>
                                                        </div>
                                                        

                                                
                                                    </div>
                                                     <input type="hidden" name="appointmentID" value="{{$appointment->id}}" />
                                                     <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>



@endsection
@section('scripts')


    <!-- data-table js -->
    <script src="/files/bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"
            type="text/javascript"></script>
    <script src="/files/assets/pages/data-table/js/jszip.min.js" type="text/javascript"></script>
    <script src="/files/assets/pages/data-table/js/pdfmake.min.js" type="text/javascript"></script>
    <script src="/files/assets/pages/data-table/js/vfs_fonts.js" type="text/javascript"></script>
    <script src="/files/bower_components/datatables.net-buttons/js/buttons.print.min.js"
            type="text/javascript"></script>
    <script src="/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"
            type="text/javascript"></script>
    <script src="/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"
            type="text/javascript"></script>
    <script src="/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"
            type="text/javascript"></script>
    <script src="/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"
            type="text/javascript"></script>
    <!-- Select2 Files -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>


    <script type="text/javascript" src="/files/assets/pages/advance-elements/moment-with-locales.min.js"></script>
    
    <script type="text/javascript" src="/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript"
            src="/files/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

    <script type="text/javascript" src="/files/bower_components/datedropper/js/datedropper.min.js"></script>

    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>




    <script>
        var table;
        var lastLoadedUserId=0;
        $(document).ready(function () {

            var fullDate = new Date();
            //console.log(fullDate);
            //Thu May 19 2011 17:25:38 GMT+1000 {}

            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);

            var currentDate = fullDate.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
            //console.log(currentDate);

            $("#dateFrom").val('{{Carbon\Carbon::now()->format("d-m-Y")}}');
            $("#dateFrom").dateDropper({
                dropWidth: 200,
                format: "d-m-Y",
                dropPrimaryColor: "#1abc9c",
                dropBorder: "1px solid #1abc9c"
            });
             $('#timeFrom').datetimepicker({
                    format: 'LT'
                });

        });
    </script>

    <script>
      

        function validate_booking() {
            var proceed=1;
            var selectedDateParts=$('#dateFrom').val().split("-");
            var selectedDate=new Date(selectedDateParts[2],selectedDateParts[1]-1,selectedDateParts[0]);
            var today=new Date();
            today.setHours(0);
            today.setMinutes(0);
            today.setSeconds(0);
            today.setMilliseconds(0);
            if($('#select_patient').val()=="0")
                {
                    proceed=0;
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
                else if(today>selectedDate)
                {
                    proceed=0;
                    swal({
                        title: "Error",
                        text: "You cannot set date from past!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
                     return false;
                }
                else if($('#lblOnline').is(':checked') && ($('#meetingID').val()=="" || $('#modPasscode').val()=="" || $('#participantsCode').val()==""))
                {
                    proceed=0;
                    swal({
                        title: "Error",
                        text: "Please Enter Online Appointment Info!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
                     return false;
                   
                }
                else
                {
                    return true;
                }
                
        }
    </script>

    <script type="text/javascript">
        @if(isset($errMSg))
        @if($errMSg=="Success")
        swal({
            title: "Saved",
            text: "Appointment saved successfully!",
            type: "success",
            showCancelButton: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK!",
            closeOnConfirm: true
        });
        @elseif($errMSg=="SuccessLoad")
        {
            swal({
            title: "Saved",
            text: "Appointment Info Loaded!",
            type: "success",
            showCancelButton: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK!",
            closeOnConfirm: true
        });
        }
        @elseif($errMSg=="SuccessDelete")
        {
            swal({
            title: "Deleted",
            text: "Appointment Info Deleted!",
            type: "success",
            showCancelButton: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK!",
            closeOnConfirm: true
        });
        }
        @else
        swal({
            title: "Error",
            text: "Error: {{ $errMSg }}",
            type: "error",
            showCancelButton: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK!",
            closeOnConfirm: true
        });
        @endif
        @endif

        function isOnline() {
            if ($('#lblOnline').is(':checked')) {
                $("#onlineMeetingDiv").show();
            }
            else
            {
                 $("#onlineMeetingDiv").hide();
            }
        }
    </script>
@endsection