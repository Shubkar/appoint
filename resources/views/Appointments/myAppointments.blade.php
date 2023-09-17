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
                            <li class="breadcrumb-item"><a href="#!">Manage Customers</a></li>
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
                                        <h5>Appointments Booking</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="select_employee">Select Employee</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2Box" id="select_employee"
                                                        name="select_employee" onchange="loadData()">
                                                    <option value="0">Select Employee</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{$employee->id}}" data-calendarurl="{{$employee->calendarUrl}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <table id="footer-search"
                                                   class="table table-striped table-bordered dt-responsive dataTable"
                                                   role="grid" aria-describedby="footer-search_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Salary: activate to sort column ascending">
                                                        Action
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Salary: activate to sort column ascending">
                                                        Name
                                                    </th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending">Case ID
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        Mobile
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Appointment Time
                                                    </th>
                                                </tr>
                                                </thead>
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

    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.1/sweetalert.min.js"></script>
    <script>
        var table;
        $(document).ready(function () {

            @if (session()->has('selectedUserId'))
            //set selection
            $("#select_employee").val("{{session('selectedUserId')}}");
            loadData();
            @endif
            $('.select2Box').select2();
        });

        function loadData() {
            $('#footer-search').dataTable().fnClearTable();
            $('#footer-search').dataTable().fnDestroy();
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
                "scrollX": true,
                "ajax":"/getAllAppointments/"+$('#select_employee').val(),
                "columns": [
                    {"data": "action","searchable": false},
                    {"data": "customerName"},
                    {"data": "caseId"},
                    {"data": "mobileNumber"},
                    {"data": "dtStart"}
                ],
                "deferRender": true,
                "initComplete":function( settings, json){
                    //console.log(json);
                    expandAllDt();
                    // call your function here
                }
            });


        }

        function expandAllDt() {
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
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
    </script>
@endsection
