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
                            <h5>Send Message</h5>
                            <span>Manage Message Queue</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Send Message</a></li>
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
                                        <h5>Appointments To Send Message</h5>
                                    </div>
                                    <div class="card-block">
                                        

                                        <form name="frm_newAppointment" id="frm_newAppointment" method="POST" action="/appointments/addToQueue">
                                        <div class="form-group row">
                                            <label class="col-md-2 col-sm-6 col-xs-6 col-form-label" for="select_template">Select Template</label>
                                            <div class="col-md-8 col-sm-6 col-xs-6">
                                                <select class="form-control select2Box" id="select_template"
                                                        name="select_template">
                                                    @foreach($templates as $template)
                                                        <option value="{{$template->id}}">{{$template->msg_type}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="selectedIds" id="selectedIds" value="{{$selectedIds}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <button type="submit"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Add To Queue
                                                </button>
                                                        </div>
                                                        

                                                
                                                    </div>
                                                     <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        </form>
                                        
                                        
                                           
                                        
                                        <div class="form-group row">
                                            <table id="footer-search"
                                                   class="table table-striped table-bordered dt-responsive dataTable display select"
                                                   role="grid" aria-describedby="footer-search_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending">Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Case ID
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Time
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        Mobile
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($appointments as $appoint)
                                                        <tr>
                                                            <td>{{$appoint->customerName}}</td>
                                                            <td>{{$appoint->caseId}}</td>
                                                            <td>{{$appoint->dtStart}}</td>
                                                            <td>{{$appoint->mobileNumber}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
            $('.select2Box').select2();
 //loadData();
  $('#footer-search').dataTable();
        });

        

        function loadData() {

            $('#footer-search').dataTable().fnClearTable();
            $('#footer-search').dataTable().fnDestroy();
            // DataTable
            table = $('#footer-search').DataTable({
               
                fixedHeader: {
                    header: true
                },
                "initComplete":function( settings, json){
                    //console.log(json);
                    expandAllDt();
                }
            });

           

   
         }

        function expandAllDt() {
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        }
    </script>

    <script>
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
        swal({
            title: "Saved",
            text: "Message Queue saved successfully!",
            type: "success",
            showCancelButton: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK!",
            closeOnConfirm: true
        });
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