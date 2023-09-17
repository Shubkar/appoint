@extends('layouts.app')
@section('headerScripts')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

    <!-- Modal -->
    <link rel="stylesheet" type="text/css" href="/files/bower_components/sweetalert/css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <meta name="_token" content="{{csrf_token()}}"/>
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
                            <h5>Doctor Management</h5>
                            <span>Manage Doctors</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Manage Doctors</a></li>
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
                                        <h5>Doctor's List</h5>
                                    </div>
                                    <div class="card-block">

                                        <div class="row">
                                           <div class="col-md-3">
                                                <input type="checkbox" name="chkInactive" id="chkInactive" onchange="showActive()"/> Show Inactive
                                            </div>
                                            <div class="col-md-3 offset-3">
                                                <a href="/Users/editUser/0"><button type="button"
                                                                                    class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                        New Doctor
                                                    </button></a>
                                            </div>
                                        </div>
                                        <table id="footer-search"
                                               class="table table-striped table-bordered dt-responsive dataTable"
                                               role="grid" aria-describedby="footer-search_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                    aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending">Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Position: activate to sort column ascending">Email
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Office: activate to sort column ascending">
                                                    Mobile Number
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Age: activate to sort column ascending">User Type
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Start date: activate to sort column ascending">Takes Appointment
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Calendar
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                    aria-label="Salary: activate to sort column ascending">
                                                    Action
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
    <script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>

    <script>
        var table;

        function showActive()
        {
            if ($('#chkInactive').is(':checked')) {
             table.ajax.url("/getAllUsers/0")
                .load();
            }
            else
            {
                 table.ajax.url("/getAllUsers/1")
                .load();
            }
        }

        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#footer-search thead th.searching').each(function () {
                var title = $(this).text();
                if(title=='Action' || title=="Calendar" || title=="Takes Appointment")
                {
                    $(this).html(title);
                }
                else {
                    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
                }
            });

            // DataTable
            table = $('#footer-search').DataTable({
                "processing": true,
                "serverSide": true,
                "scrollX": true,
                fixedHeader: {
                    header: true
                },
                "ajax": "/getAllUsers",
                "columns": [
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "mobile"},
                    {"data": "userType"},
                    {"data": "takesAppointment","searchable": false},
                    {"data": "calendarUrl","searchable": false},
                    {"data": "action","searchable": false},
                ],
                "deferRender": true
            });
            // Apply the search
            /*table.columns().every(function () {
                var that = this;

                $('input', this.header()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });*/
        });

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

    <script type="text/javascript">
        function deleteUserInfo(customerId,status) {
            if(status==1)
            {
                swal({
                title: "Confirm Inactive",
                text: "Do you Want to Mark this Doctor Inactive",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                sendAjaxRequest(customerId,status);
            });
            }
            else
            {
                swal({
                title: "Confirm Active",
                text: "Do you Want to Mark this Doctor Active",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                sendAjaxRequest(customerId,status);
            });
            }

        }

        function sendAjaxRequest(id,status) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/deleteUser') }}",
                method: 'post',
                data: {
                    id: id,
                    status: status
                },
                success: function (result) {
                    if(result.success==1)
                    {
                        swal({
                            title: "Error",
                            text: "Doctor is logeed in!",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    }
                    else {
                        swal({
                            title: "Success",
                            text: "Doctor Info Updated successfully!",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    }

                    table.ajax.reload();
                    //notify('top', 'center', 'fa fa-user-times', 'success', 'animated fadeIn', 'animated fadeOut', 'Template Saved Successfully');
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
