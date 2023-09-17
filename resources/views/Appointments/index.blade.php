@extends('layouts.app')
@section('headerScripts')



    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">


    <style>

        .fixedHeader-floating
        {
            top:63px !important;
            z-index:9999;
        }

        .btn i {
            margin: 0px !important;
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
                            <h5>Appointment Management</h5>
                            <span>Manage Appointments</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Book Appointments</a></li>
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
                                        <h5>New Appointment</h5>
                                    </div>
                                    <div class="card-block">
                                        <form name="frm_newAppointment" id="frm_newAppointment" method="POST" action="/appointments/newAppointment">
                                        <div class="form-group row">
                                            <label style="text-align: right;" class="col-md-2 col-sm-6 col-xs-6 col-form-label" for="select_employee">Select Doctor</label>
                                            <div class="col-md-4 col-sm-6 col-xs-6">
                                                <select class="form-control select2Box" id="select_employee"
                                                        name="select_employee" onchange="loadCustomers()">
                                                    <option value="0">Select Doctor</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{$employee->id}}" data-calendarurl="{{$employee->calendarUrl}}" data-meetingID="{{$employee->meetingID}}" data-modPasscode="{{$employee->modPasscode}}" data-participantsCode="{{$employee->participantsCode}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <label style="text-align: right;" class="col-md-2 col-sm-6 col-xs-6 col-form-label" for="select_patient">Select Patient</label>
                                            <div class="col-md-4 col-sm-6 col-xs-6">
                                               <select class="form-control select2Box" id="select_patient"
                                                        name="select_patient"  onchange="loadData()">
                                                    <option value="0">Select Patient</option>
                                                </select>
                                            </div>
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
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <div class="row">
                                                   <div class="col-sm-4"><input type="radio" name="lblCaseType" id="regularCase" value="Regular" checked /> Regular</div>
                                                   <div class="col-sm-4"><input type="radio" name="lblCaseType" id="newCase" value="NC" /> New Case</div>
                                                   <div class="col-sm-4"><input type="radio" name="lblCaseType" id="retake" value="RETAKE" /> Retake</div>
                                               </div>
                                            </div>
                                                   <div class="col-md-4 col-sm-4 col-xs-12" id="onlineMeetingDiv">

                                                    <input type="checkbox" name="lblOnline" id="lblOnline" value="1" /> Online Appointment
                                                    <input type="hidden" name="meetingID" id="meetingID"
                                                               class="form-control" placeholder="Meeting ID">
                                                                <input type="hidden" name="modPasscode" id="modPasscode"
                                                               class="form-control" placeholder="Mod Passcode">
                                                               <input type="hidden" name="participantsCode" id="participantsCode"
                                                               class="form-control" placeholder="Participants Code">
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
                                                     <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">



                            <div class="col-md-12 col-xl-12 col-sm-12">
                                <div class="card sale-card">
                                    <div class="card-header row">
                                        <div class="col-sm-12 col-md-6">
                                        <h5>Appointments Booking</h5>
                                        </div>
                                        <div class="col-sm-12 col-md-6" style="text-align: right;">
                                            <form name="frmGetBookings" id="frmGetBookings" method="POST" action="/appointments/getFromServer">
                                                            <button type="submit" onclick="return validate_server_fetch()"
                                                        class="btn btn-primary btn-md waves-effect waves-light">
                                                    <i class="feather icon-refresh-cw"></i> Google Server
                                                </button>
                                                <input type="hidden" name="callingPage" id="callingPage" value="BOOK" />
                                                <input type="hidden" name="calendarId" id="calendarId" value="0" />
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                </form>
                                        </div>
                                    </div>
                                    <div class="card-block">





                                                 <div class="form-group row">
                                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                                        <input type="text" name="filterFrom" id="filterFrom"
                                                               class="form-control" placeholder="From Date" required>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 col-xs-12">
<input type="text" name="filterTo" id="filterTo" placeholder="To Date"
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                                        <button type="button" onclick="setTomorrowDate()"
                                                        class="btn btn-primary btn-sm waves-effect waves-light">
                                                        Tomorrow
                                                </button>
                                                    </div>
                                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                                        <button type="button" onclick="loadData()"
                                                        class="btn btn-primary btn-sm waves-effect waves-light"><i class="feather icon-search"></i>
                                                   Search
                                                </button>
                                                    </div>
                                                    <div class="col-md-2 col-sm-12 col-xs-12" style="text-align: right;">
                                                        <form id="frm-example" name="frm-example" method="POST" action="/appointments/sendMessage">
                                                        <button type="submit" onclick="return sendMsgSubmitted()"
                                                        class="btn btn-primary btn-sm waves-effect waves-light"><i class="feather icon-message-circle"></i>
                                                   Message
                                                </button>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        </form>
                                                    </div>
                                                </div>





                                        <div class="form-group row">
                                            <table id="footer-search"
                                                   class="table table-striped table-bordered dt-responsive dataTable display select"
                                                   role="grid" aria-describedby="footer-search_info">
                                                <thead>
                                                <tr role="row">
                                                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Salary: activate to sort column ascending">
                                                        Action
                                                    </th>
                                                     <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Case ID
                                                    </th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending">Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Date
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Time
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        Mobile
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        Email
                                                    </th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-sm-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Appointment Calendar</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">

                                            <iframe id="myIframe" class="col-md-12" style="height: 500px;"></iframe>
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




    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>




    <script>
        var table;
        var lastLoadedUserId=0;
        $(document).ready(function () {

            @if (session()->has('selectedUserId'))
            //set selection
            $("#select_employee").val("{{session('selectedUserId')}}");
            loadCustomers();
            @else
            $("#select_employee").val("1");
            loadCustomers();
            @endif
            $('.select2Box').select2();

            var fullDate = new Date();
            //console.log(fullDate);
            //Thu May 19 2011 17:25:38 GMT+1000 {}

            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);

            var currentDate = fullDate.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
            //console.log(currentDate);

            $("#dateFrom").val('{{Carbon\Carbon::now()->format("d-m-Y")}}');
            $('#filterFrom').val('{{Carbon\Carbon::now()->subYear()->format("d-m-Y")}}');
            $('#filterTo').val('{{Carbon\Carbon::now()->addMonths(2)->format("d-m-Y")}}');
             @if(session()->has('toDate'))
                $('#filterTo').val('{{session()->get("toDate")}}');
            @endif
            @if(session()->has('fromDate'))
                $('#filterFrom').val('{{session()->get("fromDate")}}');
            @endif
            /* $("#dateFrom").dateDropper({
                dropWidth: 200,
                format: "d-m-Y",
                large: true,
                largeDefault: true
            });
            $("#filterFrom").dateDropper({
                dropWidth: 200,
                format: "d-m-Y",
                large: true,
                largeDefault: true
            });
            $("#filterTo").dateDropper({
                dropWidth: 200,
                format: "d-m-Y",
                large: true,
                largeDefault: true
            }); */
            $('#dateFrom').datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
});
$('#filterFrom').datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
});
$('#filterTo').datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
});
             $('#timeFrom').datetimepicker({
                    format: 'HH:mm'
                });

        });

        function loadCustomers() {
             document.getElementById('myIframe').src = $('#select_employee').find(':selected').data('calendarurl');
             $("#meetingID").val($('#select_employee').find(':selected').data('meetingid'));
             $("#modPasscode").val($('#select_employee').find(':selected').data('modpasscode'));
             $("#participantsCode").val($('#select_employee').find(':selected').data('participantscode'));

             $('#calendarId').val($('#select_employee').val());
             if($('#select_employee').val()!="0" || $('#select_employee').val()!="")
             {
            $('#select_patient').empty();
            $("#select_patient").append("<option value='0'>Loading...</option>");
            // AJAX request
         $.ajax({
           url: '/loadCustomers/'+$('#select_employee').val(),
           type: 'get',
           dataType: 'json',
           success: function(response){
               $('#select_patient').empty();
               $("#select_patient").append("<option value='0'>Select Patient</option>");
             var len = 0;
             if(response != null){
               len = response.length;
             }
             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){

                 var id = response[i].id;
                 var name = response[i].name+"#"+response[i].caseId+"#"+response[i].mobile;

                 var option = "<option value='"+id+"'>"+name+"</option>";

                 $("#select_patient").append(option);
               }
             }

           }
        });
             }
           loadData();
        }

        function loadData() {
           // if(lastLoadedUserId!=$('#select_employee').val())
            //{



            $('#footer-search').dataTable().fnClearTable();
            $('#footer-search').dataTable().fnDestroy();
            // DataTable
            table = $('#footer-search').DataTable({
                "processing": true,
                "serverSide": true,
                fixedHeader: {
                    header: true
                },
                "ajax":"/getAppointments/"+$('#select_employee').val()+"/"+$('#select_patient').val()+"/"+$('#filterFrom').val()+"/"+$('#filterTo').val(),
                "columns": [
                    {"data": "id"},
                    {"data": "action","searchable": false},
                    {"data": "caseId"},
                    {"data": "customerName"},
                    {"data": "dtStart"},
                    {data: 'aTime', name: 'dtStart'},
                    {"data": "mobileNumber"},
                    {"data":"email","name":"customers.email"},
                ],
                "pageLength": 25,
                'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
         }
      }],
                "initComplete":function( settings, json){
                    $("#footer-search").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                    //console.log(json);
                    expandAllDt();
                    lastLoadedUserId=$('#select_employee').val();
                    // call your function here
                }
            });

            // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#footer-search tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });


            //document.getElementById('myIframe').src = $('#select_employee').find(':selected').data('calendarurl');
           // }
         }

        function expandAllDt() {
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        }

        function sendMsgSubmitted() {
            var result=false;
             var data = table.rows().data();
 data.each(function (value, index) {
     var row = table.row(index);
     var tr = $(row.node());
    var checkbox = $(tr).find('td:first-child input[type="checkbox"]')
    if($(checkbox).is(':checked')){
        $('#frm-example').append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', 'selectedIds[]')
                     .val($(checkbox).val())
               );
               result=true;
    }

 });

 if(!result)
 {
     swal({
                        title: "Error",
                        text: "Please Select appointment!",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: false
                    });
 }
      return result;
        }
    </script>

    <script>
        function setTomorrowDate() {
             $("#filterFrom").val('{{Carbon\Carbon::now()->addDays(1)->format("d-m-Y")}}');
            $("#filterTo").val('{{Carbon\Carbon::now()->addDays(1)->format("d-m-Y")}}');
            loadData();
        }
        window.setInterval("reloadIFrame();", 30000);

        function reloadIFrame() {
            document.getElementById('myIframe').src = $('#select_employee').find(':selected').data('calendarurl');
        }

        function navigateCalendar(ele) {
            window.open($(ele).data("loadcal")+"&src="+$.urlParam('src'));
        }

        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec($('#select_employee').find(':selected').data('calendarurl'));
            if (results==null){
                return null;
            }
            else{
                return results[1] || 0;
            }
        }

        function validate_booking() {
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
                else if(today>selectedDate)
                {
                    checkPassword();
                     return false;
                }
                else
                {
                    $('#frm_newAppointment').attr('action', '/appointments/newAppointment');
                    return true;
                }

        }

        function checkPassword() {
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
                checkPasswordAjax(inputValue);
            });
        }

        function checkPasswordAjax(inputValue) {
            var lblOnline=0;
            if($('#lblOnline').is(':checked'))
            {
                lblOnline=1;
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
                    Quick_select_patient: $('#select_patient').val(),
                    Quick_select_employee: $('#select_employee').val(),
                    chkQuickNewPatient: 0,
                    Quick_enter_patient: '',
                    Quick_enter_patientMobile: '',
                    Quick_enter_patientCase: '',
                    Quick_dateFrom: $('#dateFrom').val(),
                    Quick_timeFrom: $('#timeFrom').val(),
                    Quick_lblOnline: lblOnline,
                    Quick_lblCaseType: $('input[name="lblCaseType"]:checked').val(),
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
                    },function () {
                        window.location="/appointments/manageAppointment";
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

        function validate_server_fetch() {
            if($('#calendarId').val()=="0" || $('#calendarId').val()=="")
                {
                    proceed=0;
                    swal({
                        title: "Error",
                        text: "Please Select Doctor to Fetch Appointments!",
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
                @if(isset($followupAppointment))
                    @if($followupAppointment!=null)
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
                            sendWhatsappMsg('{{$whatsappMsg}}','{{$followupAppointment->mobileNumber}}')
                        //$('#msg_{{$followupAppointment}}')[0].click();
                            //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        }
                        });
                    @else
                        swal({
                            title: "Saved",
                            text: "Appointment saved successfully!",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    @endif
                @else
                    swal({
                        title: "Saved",
                        text: "Appointment saved successfully!",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                @endif
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
        @elseif($errMSg=="SuccessQueue")
        {
            swal({
            title: "Added",
            text: "Messages added to Queue!",
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

        function sendWhatsappMsg(msg,mobileNumbers) {

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
    </script>
@endsection
