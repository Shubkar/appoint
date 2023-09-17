@extends('layouts.app')
@section('headerScripts')
<link rel="stylesheet" type="text/css" href="/files/assets/icon/glyph/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css">

    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css"/>

    {{-- <link rel="stylesheet" type="text/css" href="/files/bower_components/datedropper/css/datedropper.min.css"/> --}}
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #FFFFFF !important;
        }

        .select2-container .select2-selection--single {
            height: 46px !important;
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
                            <h5>Edit Appointment</h5>
                            <span>Edit Appointment Info</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="/customers/getCustomersList">Manage Appointment</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit Appointment</a></li>
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
                                              action="/appointments/rescheduleAppointment">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label" for="caseId">Case ID</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="caseId" id="caseId"
                                                               class="form-control {{ $errors->has('caseId') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->caseId}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label" for="customerName">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="customerName" id="customerName"
                                                               class="form-control {{ $errors->has('customerName') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->customerName}}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Mobile No</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="mobileNumber" id="mobileNumber"
                                                               class="form-control {{ $errors->has('mobileNumber') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->mobileNumber}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Date</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="dtStart" id="dtStart"
                                                               class="form-control {{ $errors->has('dtStart') ? ' is-invalid' : '' }}"
                                                               value="{{\Carbon\Carbon::parse($appointment->dtStart)->format('d-m-Y')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Start Time</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="dtStartTime" id="dtStartTime"
                                                               class="form-control {{ $errors->has('dtStartTime') ? ' is-invalid' : '' }}"
                                                               value="{{\Carbon\Carbon::parse($appointment->dtStart)->format('H:i')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                   <div class="col-sm-4"><input type="radio" name="lblCaseType" id="regularCase" value="Regular" checked /> Regular</div>
                                                   <div class="col-sm-4"><input type="radio" name="lblCaseType" id="newCase" value="NC" {{$appointment->appointFlag=='NC'?'checked':''}} /> New Case</div>
                                                   <div class="col-sm-4"><input type="radio" name="lblCaseType" id="retake" value="RETAKE" {{$appointment->appointFlag=='RETAKE'?'checked':''}} /> Retake</div>
                                               </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="checkbox" name="isOnline" id="isOnline"
                                                               class="{{ $errors->has('isOnline') ? ' is-invalid' : '' }}"
                                                               value="{{$appointment->isOnline}}" {{ $appointment->isOnline==1 ? 'checked' : '' }}  onchange="processIsOnline()" /> Online Appointment
                                                    </div>
                                                </div>

                                                <div id="onlineMeetingDiv" style="{{ $appointment->isOnline==1 ? 'display:block' : 'display:none' }}">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Meeting ID</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="meetingID" id="meetingID"
                                                                class="form-control {{ $errors->has('meetingID') ? ' is-invalid' : '' }}"
                                                                value="{{$appointment->meetingID}}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Mod Passcode</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="modPasscode" id="modPasscode"
                                                                class="form-control {{ $errors->has('modPasscode') ? ' is-invalid' : '' }}"
                                                                value="{{$appointment->modPasscode}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Participants Code</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="participantsCode" id="participantsCode"
                                                                class="form-control {{ $errors->has('participantsCode') ? ' is-invalid' : '' }}"
                                                                value="{{$appointment->participantsCode}}">
                                                        </div>
                                                    </div>
                                                    
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <input type="hidden" value="{{$appointment->id}}" name="id" id="id">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <a type="button" style="color: #FFFFFF" href="/appointments/deleteAppointment/{{$appointment->id}}"
                                                                class="btn btn-danger btn-md btn-block waves-effect text-center m-b-20" onclick="return confirm('Do you want to delete this appointment?')">
                                                            Delete
                                                    </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                            Update Appointment
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                         <button type="button"
                                                                class="btn btn-inverse btn-md btn-block waves-effect text-center m-b-20" onclick="goBack()">
                                                            Back
                                                        </button>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row" style="margin-top: 50px;">
                                        <iframe id="myIframe" class="col-md-12" style="height: 500px;" src="{{$user->calendarUrl}}"></iframe>
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

    <!-- Select2 Files -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="/files/assets/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript"
            src="/files/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

    <script type="text/javascript" src="/files/bower_components/datedropper/datedropper.pro.min.js"></script>

    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>

    <script>
         $(document).ready(function () {
            $("#dtStart").dateDropper({
                 dropWidth: 200,
                format: "d-m-Y",
                large: true,
                largeDefault: true
            });
             $('#dtStartTime').datetimepicker({
                    format: 'HH:mm'
                });

        });

        function processIsOnline() {
            if ($('#isOnline').is(':checked')) {
                $("#onlineMeetingDiv").show();
            }
            else
            {
                 $("#onlineMeetingDiv").hide();
            }
        }

        function goBack() {
  window.history.back();
}
        </script>

@endsection