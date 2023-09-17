@extends('layouts.app')
@section('headerScripts')
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
                            <h5>Generate Letters</h5>
                            <span>&nbsp;</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="/letters/myAppointments">Letters</a></li>
                            <li class="breadcrumb-item"><a href="#!">Generate Letters</a></li>
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
                                        <h5>Generate Letters</h5>
                                    </div>
                                    <div class="card-block">
                                        {{--<form method="get"
                                              action="#">--}}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" for="letterType">Letter Type</label>
                                                <div class="col-sm-5">
                                                    <select name="letterType" id="letterType" class="form-control js-example-basic-single">
                                                        <option value="Receipt">Receipt</option>
                                                        <option value="Sick Leave">Sick Leave</option>
                                                        <option value="Prescription">Prescription</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                        <input class="border-checkbox" type="checkbox" id="showRef" name="showRef">
                                                        <label class="border-checkbox-label" for="showRef">Hide Ref Homeopathy Consultant</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="hidden" name="loadedLetter" id="loadedLetter" />
                                                    <button type="button"
                                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" onclick="generateLetters()">
                                                        Generate
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <form name="frmLetters" id="frmLetters" method="POST" action="/appointments/saveLettersData">
                                                <input type="hidden" name="sickLeaveData" id="sickLeaveData" value="{{$sickLeaveData->letterData}}" />
<input type="hidden" name="receiptData" id="receiptData" value="{{$receiptData->letterData}}" />

                                                <input type="hidden" name="prescriptionData" id="prescriptionData" value="{{$prescriptionData->letterData}}"/>

<input type="hidden" name="letterTypeData" id='letterTypeData' value="Receipt" />
<input type="hidden" name="appointmentId" id='appointmentId' value="{{$appointment->id}}" />
<input type="hidden" name="letterData" id="letterData" />
 <input type="hidden" name="_token" value="{{csrf_token()}}" />
<button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" onclick="return getLetterContents()">
                                                        Save Letters
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="col-sm-12">
                                                <textarea id="editor1" name="editor1" class="ckeditor">

                                                </textarea>
                                            </div>

                                       {{-- </form>--}}
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
    <script src="/templateEditor/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            CKEDITOR.replace( 'editor1');
            generateLetters();
        });

        function generateLetters() {
            if($( "#letterType option:selected" ).text()=="Sick Leave")
            {
                $('#loadedLetter').val('Sick Leave');
                CKEDITOR.instances.editor1.setData($( "#sickLeaveData" ).val());
                CKEDITOR.instances.editor1.addContentsCss( '/files/assets/css/printCss.css' );

            }
            else if($( "#letterType option:selected" ).text()=="Receipt")
            {
                $('#loadedLetter').val('Receipt');
                var receiptDataJ=$( "#receiptData" ).val();
                if($('#showRef').is(':checked'))
                {
                    receiptDataJ=receiptDataJ.replace("<strong>Ref Homeopathy Consultant:</strong>{{$doc->name}}", "");
                }
                CKEDITOR.instances.editor1.setData(receiptDataJ);
                CKEDITOR.instances.editor1.addContentsCss( '/files/assets/css/printCss.css' );
            }
            else
            {
                $('#loadedLetter').val('Prescription');
                CKEDITOR.instances.editor1.setData($( "#prescriptionData" ).val());
                CKEDITOR.instances.editor1.addContentsCss( '/files/assets/css/printCss.css' );
            }

        }

        function getLetterContents() {
            if($('#loadedLetter').val()!=$( "#letterType option:selected" ).text())
            {
                swal({
                    title: "Error",
                    text: "You are trying to save "+$('#loadedLetter').val() +" as "+$( "#letterType option:selected" ).text(),
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK!",
                    closeOnConfirm: true
                });
                return false;
            }
            else
            {
                $('#letterTypeData').val($( "#letterType option:selected").val());
                //alert(CKEDITOR.instances.editor1.getData());
                $('#letterData').val(CKEDITOR.instances.editor1.getData());
                return true;
            }

        }
    </script>

    <script type="text/javascript">
        @if(isset($errMSg))
        @if($errMSg=="Success")
        swal({
            title: "Saved",
            text: "Letter saved successfully!",
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
