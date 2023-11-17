@extends('layouts.app')
@section('headerScripts')
<meta name="_token" content="{{csrf_token()}}"/>
<style>
    .overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Adjust the opacity here (0.5 in this case) */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Ensure it's on top of other elements */
}

.loader {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.card-highlight{
    background-color: #71b3ff;
    box-shadow: 10px 12px 5px #8b9699;
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
                            <h5>Patient Directory Management</h5>
                            <span>Manage Patient Directory</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Manage Patients</a></li>
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
                                        <div class="d-flex justify-content-between">
                                            <h4>Files List</h4>
                                            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#FileUploadModal">Upload</button>
                                        </div>
                                    </div>
                                    <div class="card-block">

                                        
                                            <h6>Name : {{ $Customer->name }}</h6>
                                            <h6>Case Id : {{ $caseId }}</h6>
                                            <hr>

                                        <div class="row show_files">
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

<div class="overlay" style="display:none;">
    <div class="loader"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="FileUploadModal" tabindex="-1" role="dialog" aria-labelledby="FileUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post" action="/uploadPatientFile" id="uploadForm">
      <div class="modal-header">
        <h5 class="modal-title" id="FileUploadModalLabel">Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <!-- <label for="file_titile">Title ({{ $caseId }}-......)</label>
            <input type="text" name="title" class="form-control" placeholder="Enter Title or File Name" required> -->
            <label class="sr-only" for="inlineFormInputGroupUsername">Title</label>
            <div class="input-group">
                <div class="input-group-prepend">
                <div class="input-group-text">{{ $caseId }} - </div>
                </div>
                <input type="text" name="title" class="form-control" id="inlineFormInputGroupUsername" placeholder="Enter Title or File Name" required>
            </div>
        </div>
        
        <input type="file" name="upload_patient_file">
        <input type="hidden" name="caseId" value="{{ $caseId }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="uploadButton">Upload</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="FileDeleteModal" tabindex="-1" role="dialog" aria-labelledby="FileDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post" id="DeleteForm">
      <div class="modal-header">
        <h5 class="modal-title" id="FileDeleteModal">Delete File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        Confirm to delete this file <span class="fn"></span> ?
        <input type="hidden" name="id" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')


<script>
    $(document).ready(function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            show_files();
            function show_files() {
                $.post("{{ url('/fetch_all_files') }}", {caseId: {{ $caseId }}},  function(data){
                    console.log(data);
                    var filehtml = '';
                    $('.show_files').empty();
                    if(data.data.length > 0) {
                        var status = 0;
                        $.each( data.data, function( key, val ) {
                            let csshighlight = '';
                            if(status == 0) {
                                csshighlight = ' card-highlight';
                            }
                            filehtml += '<div class="col-12 col-md-4 col-lg-4"> <div class="card shadow rouded p-3'+csshighlight+'"> <div class="d-flex justify-content-between"> <h5> File : {{ $caseId }}-'+val.title+'<br><small><strong> Uploaded on :'+val.created_at+'</stromg></small></h5> <a href="'+val.filepath+'" class="btn btn-success btn-sm" target="_blank">Open</a> <button class="btn btn-danger btn-sm" type="button" data-id="'+val.id+'" data-title="'+val.title+'" data-toggle="modal" data-target="#FileDeleteModal">Delete</button> </div> </div> </div>';
                            status = 1;
                        });
                    } else {
                        filehtml = '<h5 class="p-5 text-danger"> No Files Found </h5>';
                    }
                    
                    $('.show_files').html(filehtml);
                });
            }
        

        $('#uploadButton').click(function() {
        $('.overlay').show();
            var formData = new FormData($('#uploadForm')[0]);
            
            $.ajax({
                url: "{{ url('/uploadpatientfile') }}", // Replace with the URL where your server handles the file upload
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.overlay').hide();
                    console.log(response);
                    if(response.success == 200) {
                        $('#FileUploadModal').modal('toggle');
                        $('#uploadForm').trigger("reset");
                        show_files();
                        swal({
                            title: "File Uploaded",
                            text: response.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    } else {
                        swal({
                            title: "File Upload Failed",
                            text: response.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    }
                },
                error: function(xhr) {
                    // Handle errors here
                    $('#message').html('Upload failed: ' + xhr.statusText);
                }
            });
        });

        $('#FileDeleteModal').on('show.bs.modal', function(e) { //#areas_modal model id which will be open onclick add button ,this is in blade file 
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('title');
            $(e.currentTarget).find('input[name="id"]').val(id);
            $('.fn').html('<strong class="text-info">'+name+'</strong>'); //name of input which are on blade file
        });

        $('#confirmButton').click(function() {
            var formData = new FormData($('#DeleteForm')[0]);
            
            $.ajax({
                url: "{{ url('/deletpateintFile') }}", // Replace with the URL where your server handles the file upload
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success == 200) {
                        $('#FileDeleteModal').modal('toggle');
                        show_files();
                        swal({
                            title: "File Deleted",
                            text: response.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    } else {
                        swal({
                            title: "File Delete Failed",
                            text: response.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    }
                },
                error: function(xhr) {
                    // Handle errors here
                    $('#message').html('Upload failed: ' + xhr.statusText);
                }
            });
        });

    });

    
</script>


@endsection