@extends('layouts.app')
@section('headerScripts')
<meta name="_token" content="{{csrf_token()}}"/>
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
@endsection
@section('contents')
    <div class="pcoded-content">

        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Patient</h5>
                            <span>Edit Patient Info</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="/customers/getCustomersList">Manage Patient</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit Patient</a></li>
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
                                        <h5>Patient Info</h5>
                                    </div>
                                    <div class="card-block">
                                        <form method="post"
                                              action="/saveCustomer">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="cname" id="cname"
                                                                    class="form-control {{ $errors->has('cname') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->name}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Case ID</label>
                                                            <div class="col-sm-9">
                                                                <div class="d-flex justify-content-between">
                                                                    <input type="text" name="caseId" id="caseId"
                                                                    class="form-control {{ $errors->has('caseId') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->caseId}}" readonly>
                                                                    <a href='/PatientHistory/{{ $customer->caseId }}' class='btn waves-effect waves-light btn-primary' title='Patient History'><i class="feather icon-user"></i></a>
                                                                </div>

                                                                
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Mobile No</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="mobile" id="mobile"
                                                                    class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->mobile}}">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="email" id="email"
                                                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->email}}">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Gender</label>
                                                            <div class="col-sm-9">
                                                                <select name="gender" id="gender" class="form-control select2">
                                                                    <option {{$customer->gender=='M'?'selected':''}} value="M">Male</option>
                                                                    <option {{$customer->gender=='F'?'selected':''}} value="F">Female</option>
                                                                    <option {{$customer->gender=='-'?'selected':''}} value="-">Other</option>
                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Age</label>
                                                            <div class="col-sm-9">
                                                                <input type="number" name="age" id="age"
                                                                    class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->age}}">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Occupation</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="occupation" id="occupation"
                                                                    class="form-control {{ $errors->has('occupation') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->occupation}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            @if(!empty($customer->photo))
                                                            <img src="{{$customer->photo}}" alt="profile_photo" class="img-fluid" style="height: 450px;">
                                                            @endif
                                                        </div>
                                                        <div class="row form-group">
                                                            <h6>Profile Photo : </h6>
                                                            <a  a href='/photo/{{ $customer->id }}' class='btn btn-sm waves-effect waves-light btn-warning'>Capture</a>
                                                            <a  a href='#' class='btn btn-sm waves-effect waves-light btn-info' data-id="{{ $customer->id }}" data-toggle='modal' data-target='#upload_profilePicModal'>Upload</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        
                                                    </div>
                                                    <div class="col-sm-6">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        
                                                    </div>
                                                    <div class="col-sm-6">
                                                        
                                                    </div>
                                                </div> -->

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Reffered By</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="refferedBy" id="refferedBy"
                                                                    class="form-control {{ $errors->has('refferedBy') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->refferedBy}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                        <label class="col-sm-3 col-form-label">Registered On</label>
                                                            <div class="col-sm-9">
                                                                <input type="text"
                                                                    class="form-control"
                                                                    value="{{date('d-m-Y H:i:s', strtotime($customer->created_at))}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Info Sharing</label>
                                                            <div class="col-sm-9">
                                                                <select name="infoSharing" id="infoSharing" class="form-control select2">
                                                                    <option {{$customer->infoSharing=='Yes'?'selected':''}} value="Yes">Yes</option>
                                                                    <option {{$customer->infoSharing=='No'?'selected':''}} value="No">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">NewsLetter</label>
                                                            <div class="col-sm-9">
                                                                <select name="newsLetter" id="newsLetter" class="form-control select2">
                                                                    <option {{$customer->newsLetter=='1'?'selected':''}} value="1">Yes</option>
                                                                    <option {{$customer->newsLetter=='0'?'selected':''}} value="0">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Address</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="address" id="address"
                                                                    class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->address}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Ethnicity</label>
                                                            <div class="col-sm-9">
                                                                {{-- <input type="text" name="ethnicity" id="ethnicity"
                                                                    class="form-control {{ $errors->has('ethnicity') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->ethnicity}}"> --}}
                                                                    <select name="ethnicity" id="ethnicity" class="select2 form-control">
                                                            @foreach ($ethnicities as $ethnicity)
                                                        <option {{$customer->ethnicity == $ethnicity?'selected':'' }} value="{{$ethnicity}}">{{$ethnicity}}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">ID/Passport No</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="idNumber" id="idNumber"
                                                                    class="form-control {{ $errors->has('idNumber') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->idNumber}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Remark 1</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="remark1" id="remark1"
                                                                    class="form-control {{ $errors->has('remark1') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->remark1}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 col-form-label">Remark 2</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="remark2" id="remark2"
                                                                    class="form-control {{ $errors->has('remark2') ? ' is-invalid' : '' }}"
                                                                    value="{{$customer->remark2}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row form-group">
                                                        <label class="col-sm-3 col-form-label">Date</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="dateofConsultation" id="dateofConsultation" class="form-control" value="{{$customer->dateofConsultation!=null ? \Carbon\Carbon::parse($customer->dateofConsultation)->format('d-m-Y'):''}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 offset-3">
                                                        <input type="hidden" value="{{$customer->id}}" name="id" id="id">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <button type="submit"
                                                                    class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                                Update Patient
                                                            </button>
                                                    </div>
                                                </div>

                                                
                                            </div>
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

     <!-- Profile Photo Upload Modal -->
     <div class="modal fade" id="upload_profilePicModal" tabindex="-1" role="dialog" aria-labelledby="upload_profilePicModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="UploadProfilePic" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upload_profilePicModalLabel">Upload Profile Picture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="cust_id">
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
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

    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
            $("#dateofConsultation").datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
});
        });


        $('#upload_profilePicModal').on('show.bs.modal', function(e) { 
            var id = $(e.relatedTarget).data('id');
            $(e.currentTarget).find('input[name="cust_id"]').val(id);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('.UploadProfilePic').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{url('UploadProfilePic')}}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if(data.success == "200") {
                        swal({
                            title: "Success",
                            text: data.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                        $('#upload_profilePicModal').modal('toggle');
                        $('.UploadProfilePic').trigger("reset"); //#states_form id which form  idneeds to be reset(reset form)
                        // $('#footer-search').DataTable().ajax.reload();
                        location.reload(true)
                    } else {  
                        swal({
                            title: "Error",
                            text: data.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    }
                },
                error:function(data){
                    swal({
                        title: "Error",
                        text: data.message,
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                }
            });
        });
    </script>
@endsection