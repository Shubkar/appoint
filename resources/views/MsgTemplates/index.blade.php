@extends('layouts.app')
@section('headerScripts')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #FFFFFF !important;
        }

        .select2-container .select2-selection--single {
            height: 46px !important;
        }

        header {
		position: relative;
}

.hide {
		display: none;
}

.tab-content {
		padding:25px;
}

#material-tabs {
		position: relative;
		display: block;
	  padding:0;
		border-bottom: 1px solid #e0e0e0;
}

#material-tabs>a {
		position: relative;
	 display:inline-block;
		text-decoration: none;
		padding: 22px;
		text-transform: uppercase;
		font-size: 14px;
		font-weight: 600;
		color: #424f5a;
		text-align: center;
		outline:;
}

#material-tabs>a.active {
		font-weight: 700;
		outline:none;
}

#material-tabs>a:not(.active):hover {
		background-color: inherit;
		color: #7c848a;
}

@media only screen and (max-width: 520px) {
		.nav-tabs#material-tabs>li>a {
				font-size: 11px;
		}
}

.yellow-bar {
		position: absolute;
		z-index: 10;
		bottom: 0;
		height: 3px;
		background: #458CFF;
		display: block;
		left: 0;
		transition: left .2s ease;
		-webkit-transition: left .2s ease;
}

#tab1-tab.active ~ span.yellow-bar {
		left: 0;
		width: 160px;
}

#tab2-tab.active ~ span.yellow-bar {
		left:165px;
		width: 82px;
}

#tab3-tab.active ~ span.yellow-bar {
		left: 253px;
		width: 135px;
}

#tab4-tab.active ~ span.yellow-bar {
		left:392px;
		width: 163px;
}
    </style>
    <meta name="_token" content="{{csrf_token()}}"/>

@endsection
@section('contents')
    <div class="pcoded-content">

        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Settings</h5>
                            <span>App Settings &amp; Message Templates</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Message Templates</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">


                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <header>
				<div id="material-tabs">
						<a id="tab1-tab" href="#tab1" class="active">App Settings</a>
						<a id="tab2-tab" href="#tab2">Templates</a>
						<a id="tab3-tab" href="#tab3">Masters</a>
						{{--<a id="tab4-tab" href="#tab4">GESTION D'ACTIFS</a> --}}
						<span class="yellow-bar"></span>
				</div>
		</header>

		<div class="tab-content">
				<div id="tab1">
						<div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Invoice Start From</h5>
                                    </div>
                                    <div class="card-block">
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Start From</label>
                                            <div class="col-sm-6">
                                                <input type="number" value="{{$appSettings->settingValue}}" id="txtStartInvoice" id="txtStartInvoice" min="1" class="form-control">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="saveSettings(1,$('#txtStartInvoice').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Consultation Fees</label>
                                            <div class="col-sm-6">
                                                <input type="number" value="{{$consultation->settingValue}}" id="txtConsultation" name="txtConsultation" min="1" class="form-control">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="saveSettings(2,$('#txtConsultation').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Repeat Consultation Fees</label>
                                            <div class="col-sm-6">
                                                
                                                <input type="number" value="{{$rConsultation->settingValue}}" id="txtrConsultation" name="txtrConsultation" min="1" class="form-control">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="saveSettings(3,$('#txtrConsultation').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="pharmacistNo">Pharmacist No</label>
                                            <div class="col-sm-6">
                                               <div class="input-group input-group-inverse">
<span class="input-group-prepend">
<label class="input-group-text">+</label>
</span>
 <input type="number" value="{{$pharmacistNo->settingName}}" id="pharmacistNo" name="pharmacistNo" min="1" class="form-control">
</div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="saveSettings(4,$('#pharmacistNo').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="ncTime">New Case Time</label>
                                            <div class="col-sm-6">
                                               <div class="input-group input-group-inverse">
 <input type="number" value="{{$ncTime->settingValue}}" id="ncTime" name="ncTime" min="1" class="form-control">
</div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="saveSettings(5,$('#ncTime').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="retakeTime">Retake Time</label>
                                            <div class="col-sm-6">
                                               <div class="input-group input-group-inverse">
 <input type="number" value="{{$retakeTime->settingValue}}" id="retakeTime" name="retakeTime" min="1" class="form-control">
</div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="saveSettings(6,$('#retakeTime').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
				</div>
				<div id="tab2">
						<div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Confirmation Message</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Select Field</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select2Box" id="confirm_template"
                                                        name="confirm_template">
                                                    <option value="#FIRST#">First Name</option>
                                                    <option value="#LAST#">Last Name</option>
                                                    <option value="#CASE#">Case ID</option>
                                                    <option value="#TIME#">Appointment Time</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="insertAtCursor(document.getElementById('confirm_msg'),$('#confirm_template').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Insert
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Enter Message</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="5" class="form-control" placeholder="Message"
                                                          name="confirm_msg" id="confirm_msg"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8 offset-2">
                                                <button type="button"
                                                        onclick="sendAjaxRequest('Confirmation',0,$('#confirm_msg').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Hourly Message</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Select Hours</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2Box" id="hourly_time"
                                                        name="hourly_time">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Select Field</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select2Box" id="hourly_template"
                                                        name="hourly_template">
                                                    <option value="#FIRST#">First Name</option>
                                                    <option value="#LAST#">Last Name</option>
                                                    <option value="#CASE#">Case ID</option>
                                                    <option value="#TIME#">Appointment Time</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="insertAtCursor(document.getElementById('hourly_msg'),$('#hourly_template').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Insert
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Enter Message</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="5" class="form-control" placeholder="Message"
                                                          name="hourly_msg" id="hourly_msg"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8 offset-2">
                                                <button type="button"
                                                        onclick="sendAjaxRequest('HourBefore',$('#hourly_time').val(),$('#hourly_msg').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Daily Message</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Select Days</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2Box" id="daily_time"
                                                        name="daily_time">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Select Field</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select2Box" id="daily_template"
                                                        name="daily_template">
                                                    <option value="#FIRST#">First Name</option>
                                                    <option value="#LAST#">Last Name</option>
                                                    <option value="#CASE#">Case ID</option>
                                                    <option value="#TIME#">Appointment Time</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button"
                                                        onclick="insertAtCursor(document.getElementById('daily_msg'),$('#daily_template').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Insert
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="imgPath">Enter Message</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="5" class="form-control" placeholder="Message"
                                                          name="daily_msg" id="daily_msg"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8 offset-2">
                                                <button type="button"
                                                        onclick="sendAjaxRequest('DayBefore',$('#daily_time').val(),$('#daily_msg').val())"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
				</div>
				 <div id="tab3">
						<div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Ethnicity</h5>
                                        <small>Please Enter each value on single line</small>
                                    </div>
                                    <div class="card-block">
                                        
                                        <div class="form-group row">
                                             <label class="col-sm-2 col-form-label" for="ethnicity">Ethnicity</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="5" class="form-control" placeholder="Ethnicity"
                                                          name="ethnicity" id="ethnicity">{{$masterData->get(0)->masterValues}}</textarea>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" onclick="saveMaster(1,$('#ethnicity').val());">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Payment Modes</h5>
                                        <small>Please Enter each value on single line</small>
                                    </div>
                                    <div class="card-block">
                                        
                                        <div class="form-group row">
                                             <label class="col-sm-2 col-form-label" for="paymentMode">Payment Modes</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="5" class="form-control" placeholder="Payment Modes"
                                            name="paymentMode" id="paymentMode">{{$masterData->get(1)->masterValues}}</textarea>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" onclick="saveMaster(2,$('#paymentMode').val());">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
				</div>
				{{--			<div id="tab4">
						<p>Third tab content.</p>
				</div> --}}
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

    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2Box').select2();

            $('#material-tabs').each(function() {

				var $active, $content, $links = $(this).find('a');

				$active = $($links[0]);
				$active.addClass('active');

				$content = $($active[0].hash);

				$links.not($active).each(function() {
						$(this.hash).hide();
				});

				$(this).on('click', 'a', function(e) {

						$active.removeClass('active');
						$content.hide();

						$active = $(this);
						$content = $(this.hash);

						$active.addClass('active');
						$content.show();

						e.preventDefault();
				});
		});
        });

        function insertAtCursor(myField, myValue) {
            //IE support
            if (document.selection) {
                myField.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
            }
            //MOZILLA and others
            else if (myField.selectionStart || myField.selectionStart == '0') {
                var startPos = myField.selectionStart;
                var endPos = myField.selectionEnd;
                myField.value = myField.value.substring(0, startPos)
                    + myValue
                    + myField.value.substring(endPos, myField.value.length);
            } else {
                myField.value += myValue;
            }
        }


        function sendAjaxRequest(msgType, msgTime, msg) {
            if ((msg == "")) {
                notify('top', 'center', 'fa fa-user-times', 'danger', 'animated flipInX', 'animated flipOutX', 'Please Enter Message');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/saveTemplates') }}",
                    method: 'post',
                    data: {
                        templateType: msgType,
                        msgTime: msgTime,
                        msg: msg
                    },
                    success: function (result) {
                        console.log(result);
                        swal({
                                title: "Saved",
                                text: "Template saved successfully!",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "OK!",
                                closeOnConfirm: true
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

        }


        function saveSettings(settingId,settingValue) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/saveSettings') }}",
                    method: 'post',
                    data: {
                        settingId: settingId,
                        settingValue: settingValue
                    },
                    success: function (result) {
                        swal({
                            title: "Saved",
                            text: "Setting saved successfully!",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
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
                            msg = jqXHR.responseText;
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


        function saveMaster(id, masterValues) {
            if ((masterValues == "")) {
                notify('top', 'center', 'fa fa-user-times', 'danger', 'animated flipInX', 'animated flipOutX', 'Please Enter Data');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/saveMasterData') }}",
                    method: 'post',
                    data: {
                        masterValues: masterValues,
                        id: id
                    },
                    success: function (result) {
                        swal({
                                title: "Saved",
                                text: "Master Data saved successfully!",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "OK!",
                                closeOnConfirm: true
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

        }
    </script>
    @foreach($templates as $tm)
        <tr>
            @if($tm->msg_type == "Confirmation")
                <script>
                    var valr='{!!preg_replace( "/\r|\n/", "<br />", $tm->actual_msg )!!}';
                    $('#confirm_msg').html(valr.replace(/<br \/>/g,"\n"));

                </script>
            @elseif($tm->msg_type == "HourBefore")
                <script>
                    var valr='{!!preg_replace( "/\r|\n/", "<br />", $tm->actual_msg )!!}';
                    $('#hourly_time').val('{{$tm->msg_time}}');
                    $('#hourly_msg').html(valr.replace(/<br \/>/g,"\n"));
                </script>
                @else
                <script>
                    var valr='{!!preg_replace( "/\r|\n/", "<br />", $tm->actual_msg )!!}';
                    $('#daily_time').val('{{$tm->msg_time}}');
                    $('#daily_msg').html(valr.replace(/<br \/>/g,"\n"));
                </script>
            @endif
        </tr>
    @endforeach
@endsection