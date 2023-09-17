@extends('layouts.app')
@section('headerScripts')
    <meta name="_token" content="{{csrf_token()}}"/>
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="/files/bower_components/switchery/css/switchery.min.css">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #FFFFFF !important;
        }

        .select2-container .select2-selection--single {
            height: 46px !important;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css">

    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css"/>

    {{-- <link rel="stylesheet" type="text/css" href="/files/bower_components/datedropper/css/datedropper.min.css"/> --}}

    <link rel="stylesheet" type="text/css" href="/files/assets/icon/glyph/css/bootstrap.min.css">
@endsection
@section('contents')
    <div class="pcoded-content">

        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Payment</h5>
                            <span>Edit Payment Info</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="/reports/SummarySheet">Manage Appointment</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit Payment</a></li>
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
                                        <h5>Appointment Info</h5>
                                    </div>
                                    <div class="card-block">
                                        <form method="post"
                                              action="/payment/savePayment" id="frmAppoint">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="card-header">
                                                            <h5>Appointment Info</h5>
                                                        </div>
                                                        <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Case ID</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" {{$appointment->caseId!='NC'?'readonly':''}} name="caseId" id="caseId"
                                                               class="form-control {{ $errors->has('caseId') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->caseId}}">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" {{$appointment->caseId!='NC'?'readonly':''}} name="customerName" id="customerName"
                                                               class="form-control {{ $errors->has('customerName') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->customerName}}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="mobileNumber" id="mobileNumber"
                                                               class="form-control {{ $errors->has('mobileNumber') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->mobileNumber}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" readonly name="dtStart" id="dtStart"
                                                               class="form-control {{ $errors->has('dtStart') ? ' is-invalid' : '' }}"
                                                               value="{{$appointmentDate}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Time</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" readonly name="appointmentTime" id="appointmentTime"
                                                               class="form-control {{ $errors->has('appointmentTime') ? ' is-invalid' : '' }}"
                                                               value="{{$appointmentTime}}">
                                                    </div>
                                                </div>

                                                @if ($appointment->isOnline==1)
                                                {{-- <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Online Appointment</label>
                                                    <div class="col-sm-8">
                                                        <a href="{{$appointment->meetingID}}" target="_blank">{{$appointment->meetingID}}</a>
                                                    </div>
                                                </div> --}}
                                                 <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Meeting Id</label>
                                                    <div class="col-sm-9">
                                                        {{-- <input type="text" readonly name="meetingID" id="meetingID"
                                                               class="form-control {{ $errors->has('meetingID') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->meetingID}}"> --}}
                                                                <a href="{{$appointment->meetingID}}" target="_blank">{{$appointment->meetingID}}</a>
                                                    </div>
                                                </div> 

                                                 <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Mod Passcode</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" readonly name="modPasscode" id="modPasscode"
                                                               class="form-control {{ $errors->has('modPasscode') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->modPasscode}}">
                                                    </div>
                                                </div> 

                                                 <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Participants Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" readonly name="participantsCode" id="participantsCode"
                                                               class="form-control {{ $errors->has('participantsCode') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->participantsCode}}">
                                                    </div>
                                                </div> 
                                                    
                                                @endif

                                                <div class="form-group row">
                                                    <div class="col-sm-3">
                                                    {{-- <a href="/appointments/changeAppointmentType/{{$appointment->id}}" class="btn {{$appointment->isOnline==1?'btn-inverse':'btn-info'}} btn-md btn-block waves-effect text-center m-b-20">
                                                            {{$appointment->isOnline==1?'Change To Offline':'Change To Online'}}
                                                    </a> --}}
                                                    Online Appointment
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="checkbox" class="js-single" {{$appointment->isOnline==1?'checked':''}} />
                                                    </div>
                                                </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="card-header">
                                                            <h5>Payment Info</h5>
                                                        </div>

                                                        <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Paid</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" name="amountPaid" id="amountPaid" onkeyup="calculateBalance()"
                                                               class="form-control {{ $errors->has('amountPaid') ? ' is-invalid' : '' }}"
                                                               value="0" {{$appointment->confirmReceived==1?'readonly':''}} min="0">
                                                    </div>
                                                </div>

                                                        <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Fees</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="feeAmount" id="feeAmount" onkeyup="calculateBalance()"
                                                               class="form-control {{ $errors->has('feeAmount') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->feeAmount}}"  min="0">
                                                    </div>
                                                </div>

                                                 <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Received</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" name="alreadyPaid" id="alreadyPaid" onblur="calculateBalance()"
                                                               class="form-control {{ $errors->has('alreadyPaid') ? ' is-invalid' : '' }}"
                                                               value="{{$paidAmount}}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Balance</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" name="balancePayment" id="balancePayment"
                                                               class="form-control {{ $errors->has('balancePayment') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->feeAmount}}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Mode</label>
                                                    <div class="col-sm-9">
                                                        <select name="paymentMode" id="paymentMode" class="select2Box form-control">
                                                            @foreach ($paymodes as $paymode)
                                                        <option {{$appointment->paymentMode == $paymode?'selected':'' }} value="{{$paymode}}">{{$paymode}}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Remarks</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="remarks" id="remarks"
                                                               class="form-control {{ $errors->has('remarks') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->remarks}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="checkbox" name="confirmReceived" id="confirmReceived"
                                                               class="{{ $errors->has('confirmReceived') ? ' is-invalid' : '' }}"
                                                               {{$appointment->confirmReceived==1?'checked':''}} value="1" onchange="paymentReceived()"> Payment Received
                                                    </div>
                                                </div>

                                                    </div>
                                                </div>

                                                <table id="footer-search"
                                               class="table table-striped table-bordered dt-responsive dataTable"
                                               role="grid" aria-describedby="footer-search_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                    aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending">Date
                                                </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                    aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending">Paid Amount
                                                </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                    aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending">Action
                                                </th>
                                            </tr>
                                            </thead>

                                        </table>
                                                
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <input type="hidden" value="{{$appointment->id}}" name="id" id="id">
                                                        <input type="hidden" value="{{$today}}" id="todayDate" name="todayDate">
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <button type="submit" id="submitBtn" name="submitBtn"
                                                                class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" onclick="return validateForm()">
                                                            Save Changes
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                         
                                        <div class="row" style="margin-top: 50px;">
                                        <iframe id="myIframe" class="col-md-12" style="height: 500px;" src="{{$calendarUrl}}"></iframe>
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

            <script type="text/javascript" src="/files/assets/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript"
            src="/files/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

    <script type="text/javascript" src="/files/bower_components/datedropper/datedropper.pro.min.js"></script>

    <script type="text/javascript" src="/files/bower_components/switchery/js/switchery.min.js"></script>
    <script type="text/javascript" src="/files/assets/pages/advance-elements/swithces.js"></script>
    <script src="/files/assets/js/jquery.form.js"></script>
    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>
    
    

    <script>
        function paymentReceived()
        {
            if($('#confirmReceived').is(":checked") && $('#balancePayment').val()!=0)
            {
                $('#confirmReceived').prop('checked', false);
                swal({
                        title: "Error",
                        text: "Payment cannot be confirmed untill balance is zero",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
            }
        }
        var table;
        $(document).ready(function() {
           /* var t = $('#example').DataTable();

            $('#example tbody').on( 'click', '.icon-trash-2', function () {
                t.row( $(this).parents('tr') )
                    .remove()
                    .draw();
            } );

            $('#addRow').on( 'click', function () {
                if($('#medicineName').val()=="")
                {
                    alert('Please Enter Medicine Name');
                }
                else
                {
                    t.row.add( [
                        t.rows().count(),
                        $('#medicineName').val(),
                        '<a style="cursor: pointer;"><i class="feather icon-trash-2"></i></a>'
                    ] ).draw( false );

                    $('#medicineName').val('');
                }

            } );*/

           $('#paymentMode').val('{{$appointment->paymentMode}}');
            $('.select2Box').select2();
            $("#dateFrom").dateDropper({
                dropWidth: 200,
                format: "d-m-Y",
                large: true,
                largeDefault: true
            });

            $('#timeFrom').datetimepicker({
                    format: 'LT'
                });

            if($('#alreadyPaid').val()=='0')
            {
                $('#amountPaid').val($('#feeAmount').val());
                calculateBalance();
            }
            paymentDataTable();
            
            calculateBalance();
        } );

        function paymentDataTable() {
            table = $('#footer-search').DataTable({
                "processing": true,
                "serverSide": true,
                fixedHeader: {
                    header: true
                },
                "ajax":"/getAppointmentPayment/{{$appointment->id}}",
                "columns": [
                    {"data": "created_at"},
                    {"data": "paidAmount"},
                    {"data": "action"},
                ],
                "pageLength": 100,
                "deferRender": true
            });
        }
    </script>

    

    <script type="text/javascript">
    
        function validateForm() {
            var proceed=1;
            var fees=$('#feeAmount').val();
            var paid=$('#amountPaid').val();
            var alreadyPaid=$('#alreadyPaid').val();
            fees=fees-alreadyPaid;
            if((fees-paid)<0)
            {
                proceed=0;
                swal({
                        title: "Error",
                        text: "Paid amount cannot be greater than fees",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                    $('#amountPaid').val('0');
                    $('#balancePayment').val(fees);
            }
            else if($('#feeAmount').val()=='' || isNaN($('#feeAmount').val()))
            {
                proceed=0;
                swal({
                        title: "Error",
                        text: "Please Enter Fees Amount",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
            }
            else if($('#amountPaid').val()=='' || isNaN($('#amountPaid').val()))
            {
                proceed=0;
                swal({
                        title: "Error",
                        text: "Please Enter Paid Amount",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
            }
if(proceed==1) {
    
     $('#submitBtn').prop('disabled', true);
    if ($('#dtStart').val() != '{{$today}}') {
        checkPassword();
    } else {
        $('#todayDate').val("matchedPassword");
        $('#frmAppoint').submit();
    }
}
            return false;
        }
        function checkPassword() {
            swal({
                title: "Enter Password",
                text: "Please Enter Your Password to Edit",
                type: "input",
                inputType: "password",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (inputValue) {
                if (inputValue === false)
                {
                     $('#submitBtn').prop('disabled', false);
                    return false;
                } 
                if (inputValue === "") {
                    swal.showInputError("Please Enter Your Password!");
                    return false
                }
                checkPasswordAjax(inputValue);
            });
        }

        function checkPasswordAjax(inputValue) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/checkPassword') }}",
                method: 'post',
                data: {
                    inpass: inputValue
                },
                success: function (result) {
                    $('#todayDate').val("matchedPassword");
                    $('#frmAppoint').submit();
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

        function calculateBalance() {
            var fees=$('#feeAmount').val();
            var paid=$('#amountPaid').val();
            var alreadyPaid=$('#alreadyPaid').val();
            fees=fees-alreadyPaid;
            $('#balancePayment').val(fees-paid);
            
        }

        function deletePayment(id)
        {
            swal({
                        title: "Confirm",
                        text: "Do you want to delete this payment record?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, Delete!",
                        cancelButtonText: "No!",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm) {
					if (isConfirm) {
                       sendAjaxRequestForDelete(id);
					}
				});
        }

        function sendAjaxRequestForDelete(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/deleteAppointmentPayment') }}",
                method: 'post',
                data: {
                    id: id
                },
                success: function (result) {
                    swal({
                            title: "Deleted",
                            text: "Payment Info Deleted successfully!",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },function(isConfirm) {
					if (isConfirm) {
                       location.reload();
					}
				});
                        
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