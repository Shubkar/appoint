@extends('layouts.app')
@section('headerScripts')

    <link rel="stylesheet" type="text/css" href="/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css">

     <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="/files/assets/icon/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css"/>

    {{-- <link rel="stylesheet" type="text/css" href="/files/bower_components/datedropper/css/datedropper.min.css"/> --}}

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

    <!-- Modal -->
    <link rel="stylesheet" type="text/css" href="/files/bower_components/sweetalert/css/sweetalert.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <meta name="_token" content="{{csrf_token()}}"/>
    <style>
        .fixedHeader-floating {
            top: 63px !important;
            z-index: 999;
        }
        .btn i {
            margin: 0px !important;
        }

         .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #FFFFFF !important;
        }

        .select2-container .select2-selection--single {
            height: 46px !important;
        }
        b, strong{
            font-weight: 900 !important;
        }
        .withFolloup {
            background-color: #79fe6b !important;
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
                            <h5>Manage Appointments</h5>
                            <span>Appointment Summary Sheet</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Appointment Summary Sheet</a></li>
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

                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Report</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Doctor</label>
                                                    <div class="col-sm-8">
                                                       <select class="form-control js-example-basic-single" id="userId" name="userId">
                                                        <option value="0">All</option>
                                                        @foreach ($doctors as $doc)
                                                               <option value="{{$doc->id}}">{{$doc->name}}</option>
                                                           @endforeach
                                                       </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Patient</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtPatient" id="txtPatient" class="form-control  js-example-basic-single">
                                                            <option value="0">All</option>
                                                            @foreach ($patients as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}#{{$item->caseId}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Courier</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtCourier" id="txtCourier" class="form-control  js-example-basic-single">
                                                            <option value="-1">All</option>
                                                            <option value="0">Not Sent</option>
                                                            <option value="1">Sent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Payment</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtPayment" id="txtPayment" class="form-control js-example-basic-single">
                                                            <option value="-1">All</option>
                                                            <option value="0">Paid</option>
                                                            <option value="1">Not Paid</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Followup</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtFollowup" id="txtFollowup" class="form-control js-example-basic-single">
                                                            <option value="-1">All</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Online</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtAppoType" id="txtAppoType" class="form-control js-example-basic-single">
                                                            <option value="-1">All</option>
                                                            <option value="1">Online</option>
                                                            <option value="0">Offline</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Date
                                                        From</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="dateFrom" id="dateFrom"
                                                               class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Date
                                                        To</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="dateTo" id="dateTo"
                                                               class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Courier</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtCourier" id="txtCourier" class="form-control  js-example-basic-single">
                                                            <option value="-1">All</option>
                                                            <option value="0">Not Sent</option>
                                                            <option value="1">Sent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label" style="text-align: right;">Payment</label>
                                                    <div class="col-sm-8">
                                                        <select name="txtPayment" id="txtPayment" class="form-control js-example-basic-single">
                                                            <option value="-1">All</option>
                                                            <option value="0">Paid</option>
                                                            <option value="1">Partially Paid</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}



                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 offset-3">
                                                <button type="submit" onclick="return reloadData()"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="card-header">
                                                <h5>Payment/Courier Report</h5>
                                            </div>
                                        </div>

                                        <table id="footer-search"
                                               class="table table-striped table-bordered dt-responsive dataTable"
                                               role="grid" aria-describedby="footer-search_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                    aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending">Case ID
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Position: activate to sort column ascending">Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Office: activate to sort column ascending">
                                                    Date
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Office: activate to sort column ascending">
                                                    Time
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Start date: activate to sort column ascending">Fees
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Mode
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Balance
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Courier Sent
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Invoice #
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Remarks
                                                </th>

                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Cheif Complaint
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Symptoms
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Diagnosis
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Medicine
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Courier Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    AWB Number
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Online
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Followup
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Action
                                                </th>
                                            </tr>
                                            </thead>



                                        </table>

                                        <div class="row">
                                            <div class="col-sm-6 offset-6" id="divSum">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Upload Report</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">



    <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                            <div class="col-md-3"><h4>Select Reports</h4></div>
                            <div class="col-md-6">
                             <input type="file" name="file[]" id="file" multiple />
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" id="uploadAppointmentId" name="uploadAppointmentId" />
                                <input type="hidden" id="uploadCaseId" name="uploadCaseId" />
                              <input type="submit" name="upload" value="Upload" class="btn btn-success" />
                            </div>
                        </div>
                    </form>
                    <br />
                    <div class="progress" style="height: 25px;">
                      <div class="progress-bar progress-bar-striped progress-bar-primary" role="progressbar" aria-valuenow=""
                      aria-valuemin="0" aria-valuemax="100" style="width: 0%;height:25px;">
                        0%
                      </div>
                    </div>
                     <br />
                    <div id="success">

                    </div>
                    <br />

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
    <script type="text/javascript" src="/files/assets/js/modalEffects.js"></script>
    <script type="text/javascript" src="/files/bower_components/sweetalert/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"
            type="text/javascript"></script>

    <script type="text/javascript" src="/files/assets/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>


      <!-- Select2 Files -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script src="/files/assets/js/jquery.form.js"></script>

    <script>
        var table;
        $(document).ready(function () {
            $("#userId").val("1");
            $("#dateFrom").val("{{session()->get('DtFrom')}}");
            $("#dateTo").val("{{session()->get('DtTO')}}");
            $("#txtPatient").val("{{session()->get('PatientId')}}");
            $("#txtCourier").val("{{session()->get('courier')}}");
            $("#txtPayment").val("{{session()->get('paid')}}");
            $("#txtFollowup").val("{{session()->get('followup')}}");
            $("#txtAppoType").val("{{session()->get('isonline')}}");

            $('.js-example-basic-single').select2();
            $('#txtPatient').trigger('change');
            $('#txtCourier').trigger('change');
            $('#txtPayment').trigger('change');
            $('#txtFollowup').trigger('change');
            $('#txtAppoType').trigger('change');

           /*  @if (session()->has('DtFrom'))
            $("#dateFrom").val("{{session('DtFrom')}}");
            $("#dateTo").val("{{session('DtTO')}}");
            @else

            var fullDate = new Date();
            //console.log(fullDate);
            //Thu May 19 2011 17:25:38 GMT+1000 {}

            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);

            var currentDate = fullDate.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
            //console.log(currentDate);

            $("#dateFrom").val('{{Carbon\Carbon::now()->format("d-m-Y")}}');
            $("#dateTo").val('{{Carbon\Carbon::now()->format("d-m-Y")}}');

                    @endif */

            $("#dateFrom").datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
            });
            $("#dateTo").datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
            });
            validateForm();
            uploadForm();


        });

        function uploadForm() {
           $('form').ajaxForm({
        beforeSend:function(){
            $('#success').html('<img src="/files/assets/images/ajax-loader.gif" />');
            $('.progress-bar').text('0%');
            $('.progress-bar').css('width', '0%');
        },
        uploadProgress:function(event, position, total, percentComplete){
            $('.progress-bar').text(percentComplete + '%');
            $('.progress-bar').css('width', percentComplete + '%');
        },
        success:function(data)
        {
            if(data.success)
            {
                $('#success').html('<div class="text-success text-center"><b>Files Uploaded Successfully</b></div><br /><br />');
                //$('#success').html('<div class="text-success text-center"><b>'+data.success+'</b></div><br /><br />');
                //$('#success').append(data.image);
                $('.progress-bar').text('Uploaded');
                $('.progress-bar').css('width', '100%');
            }
        },
        error:function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
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
        $('#success').html('<div class="text-danger text-center"><b>'+msg+'</b></div><br /><br />');
    }
    });
        }
    </script>

    <script>

        function reloadData()
        {
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();

            job_start_date = fromDate.split('-');
            job_end_date = toDate.split('-');
            job_start_date[1] = job_start_date[1] - 1;
            job_end_date[1] = job_end_date[1] - 1;
            var new_start_date = new Date(job_start_date[2], job_start_date[1], job_start_date[0]);
            var new_end_date = new Date(job_end_date[2], job_end_date[1], job_end_date[0]);

            if (new_end_date >= new_start_date) {
                var dtStart=new_start_date.getFullYear()+"-"+ (new_start_date.getMonth()+1) + "-" + new_start_date.getDate();
           var dtEnd=new_end_date.getFullYear()+"-"+ (new_end_date.getMonth()+1) + "-" + new_end_date.getDate();
               // loadData(new_start_date,new_end_date);
                table.ajax.url("/reports/generateSummarysheet/"+dtStart+"/"+dtEnd+"/"+$("#userId").val()+"/"+$( "#txtCourier option:selected" ).val()+"/"+$( "#txtPayment option:selected" ).val()+"/"+$( "#txtPatient option:selected" ).val()+"/"+$( "#txtFollowup option:selected" ).val()+"/"+$("#txtAppoType").val());
                table.ajax.reload(function ( json ) {
   // expandAllDt();
    getFeeStatus(dtStart,dtEnd);
});
                //
            } else {
                swal({
                    title: "Error",
                    text: "Please Select valid Date Range",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK!",
                    closeOnConfirm: true
                });
            }
        }

        function loadData(dtStart,dtEnd) {

            dtStart=dtStart.getFullYear()+"-"+ (dtStart.getMonth()+1) + "-" + dtStart.getDate();
            dtEnd=dtEnd.getFullYear()+"-"+ (dtEnd.getMonth()+1) + "-" + dtEnd.getDate();
            /* $('#footer-search').dataTable().fnClearTable();
            $('#footer-search').dataTable().fnDestroy(); */
            // Setup - add a text input to each footer cell
            /*$('#footer-search thead th.searching').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });*/

            // DataTable
            table = $('#footer-search').DataTable({
                "processing": true,
                "serverSide": true,
                fixedHeader: {
                    header: true
                },
                "ajax":"/reports/generateSummarysheet/"+dtStart+"/"+dtEnd+"/"+$("#userId").val()+"/"+$( "#txtCourier option:selected" ).val()+"/"+$( "#txtPayment option:selected" ).val()+"/"+$( "#txtPatient option:selected" ).val()+"/"+$( "#txtFollowup option:selected" ).val()+"/"+$("#txtAppoType").val(),
                "columns": [
                    {"data": "caseId"},
                    {"data": "customerName"},
                    {"data": "dtStart"},
                    {data: 'aTime', name: 'dtStart'},
                    {"data": "feeAmount","searchable": false},
                    {"data": "paymentMode","searchable": false},
                    {"data": "balancePayment","searchable": false},
                    {"data": "courierSent","searchable": false},
                    {"data": "invoiceNumber","visible" : false,"searchable": false},
                    {"data": "remarks","visible" : false,"searchable": false},
                    {"data": "chiefComplaint","visible" : false,"searchable": false},
                    {"data": "symptoms","visible" : false,"searchable": false},
                    {"data": "dignosis","visible" : false,"searchable": false},
                    {"data": "medicine","visible" : false,"searchable": false},
                    {"data": "courier","visible" : false,"searchable": false},
                    {"data": "awbNumber","visible" : false,"searchable": false},
                    {"data": "isOnline","searchable": false},
                    {"data": "folloupBooked"},
                    {"data": "action","searchable": false},
                ],
                "pageLength": 100,
                dom: 'Bfrtip',
                buttons: [
                    {
                        "extend": 'copy',
                        "text": 'Copy',
                        "titleAttr": 'Copy',
                        "action": newexportaction,
                        "exportOptions": {
                            columns: [ 0, 1, 2, 3 ,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
                        },
                        "title": function () { return "Summary "+$('#dateFrom').val()+" - "+$('#dateTo').val(); },
                    },
                    {
                        "extend": 'excel',
                        "text": 'Excel',
                        "titleAttr": 'Excel',
                        "action": newexportaction,
                        "exportOptions": {
                            columns: [ 0, 1, 2, 3 ,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
                        },
                        "title": function () { return "Summary "+$('#dateFrom').val()+" - "+$('#dateTo').val(); },
                    },
                    {
                        "extend": 'csv',
                        "text": 'CSV',
                        "titleAttr": 'CSV',
                        "action": newexportaction,
                        "exportOptions": {
                            columns: [ 0, 1, 2, 3 ,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
                        },
                        "title": function () { return "Summary "+$('#dateFrom').val()+" - "+$('#dateTo').val(); },
                    },
                    {
                        "extend": 'pdf',
                        "text": 'PDF',
                        "titleAttr": 'PDF',
                        "action": newexportaction,
                        "exportOptions": {
                            columns: [ 0, 1, 2, 3 ,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
                        },
                        "title": function () { return "Summary "+$('#dateFrom').val()+" - "+$('#dateTo').val(); },
                    },
                    {
                        "extend": 'print',
                        "text": 'Print',
                        "titleAttr": 'Print',
                        "action": newexportaction,
                        "autoPrint": false,
                        "exportOptions": {
                            columns: [ 0, 1, 2, 3 ,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
                             stripHtml: false
                        },
                        "title": function () { return "Summary "+$('#dateFrom').val()+" - "+$('#dateTo').val(); },
                    }
                ],
                "deferRender": true,
                "initComplete":function( settings, json){
                    $("#footer-search").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                    //console.log(json);
                   // expandAllDt();
                    getFeeStatus(dtStart,dtEnd);
                    // call your function here
                },
                rowCallback: function(row, data, index) {
                    if (data.folloupBooked == 'Yes') {
                        $(row).addClass("withFolloup");
                    }
                    }
            });

        }

        /* function expandAllDt() {
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        } */
        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });
            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        }
    </script>
    <script type="text/javascript">
        @if(isset($errMSg))
        @if($errMSg=="Success")
        swal({
            title: "Saved",
            text: "Info saved successfully!",
            type: "success",
            showCancelButton: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK!",
            closeOnConfirm: true
        });
        @elseif($errMSg=="successAdded")
        swal({
            title: "Saved",
            text: "Invoice added to queue for sending!",
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

        function validateForm() {
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();

            job_start_date = fromDate.split('-');
            job_end_date = toDate.split('-');
            job_start_date[1] = job_start_date[1] - 1;
            job_end_date[1] = job_end_date[1] - 1;
            var new_start_date = new Date(job_start_date[2], job_start_date[1], job_start_date[0]);
            var new_end_date = new Date(job_end_date[2], job_end_date[1], job_end_date[0]);

            if (new_end_date >= new_start_date) {
                loadData(new_start_date,new_end_date);
            } else {
                swal({
                    title: "Error",
                    text: "Please Select valid Date Range",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK!",
                    closeOnConfirm: true
                });
            }
        }

        function sendWhatsappMsg(msg,mobileNumbers,confirmBeforeSend=0) {
            if(confirmBeforeSend==1)
            {
                if(confirm('This appointment time has already elapsed. You still want to send notification'))
                {
                    if(mobileNumbers.startsWith("+"))
                    {
                        mobileNumbers=mobileNumbers.replace("+", "");
                        console.log(mobileNumbers);
                    }
                    else
                    {
                        mobileNumbers= {{Auth::user()->default_Country_Code}}+mobileNumbers;
                    }
                    window.open("https://api.whatsapp.com/send?phone="+mobileNumbers+"&text="+msg);
                }
            }
            else
            {
                if(mobileNumbers.startsWith("+"))
                {
                    mobileNumbers=mobileNumbers.replace("+", "");
                    console.log(mobileNumbers);
                }
                else
                {
                    mobileNumbers= {{Auth::user()->default_Country_Code}}+mobileNumbers;
                }
                window.open("https://api.whatsapp.com/send?phone="+mobileNumbers+"&text="+msg);
            }
            //alert(decodeURIComponent((msg+'').replace(/\+/g, '%20')));
        }

        $(document).on("click", ".openLargeModal", function () {
     var appId = $(this).data('appointmentid');
     var caseId=$(this).data('caseid');
 $(".modal-body #uploadAppointmentId").val( appId );
 $(".modal-body #uploadCaseId").val( caseId );
    //
     // As pointed out in comments,
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});

function getFeeStatus(dtStart,dtEnd) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/reports/feeStatus/"+dtStart+"/"+dtEnd+"/"+$("#userId").val()+"/"+$( "#txtCourier option:selected" ).val()+"/"+$( "#txtPayment option:selected" ).val()+"/"+$( "#txtPatient option:selected" ).val()+"/"+$( "#txtFollowup option:selected" ).val()+"/"+$("#txtAppoType").val(),
                method: 'get',
                success: function (result) {
                    //console.log(result);
                    var originalData=$("#footer-search_info").html();
                    $("#footer-search_info").html('<strong>Total Fees: </strong>'+result.fees +' &nbsp;&nbsp;&nbsp;<strong>Total Received: </strong>' + (result.fees-result.balance) +' &nbsp;&nbsp;&nbsp;<strong>Total Balance: </strong>'+result.balance+'<br /><br />'+originalData);
                   /*  $("#txtFees").html("Total Fees: "+result.fees);
                    $("#txtReceived").html("Total Received: "+(result.fees-result.balance));
                     $("#txtBalance").html("Total Balance: "+ result.balance);  */
                  //  expandAllDt();

                },
                error: function (jqXHR, exception) {
                    console.log(jqXHR);
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
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

@endsection
