@extends('layouts.app')
@section('headerScripts')
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
                            <h5>Archive Management</h5>
                            <span>Manage Patient Archive</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Manage Archive</a></li>
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
                                    <div class="card-block">

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


<!-- Modal -->
<div class="modal fade" id="FileRestoreModal" tabindex="-1" role="dialog" aria-labelledby="FileRestoreModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post" id="RestoreForm">
      <div class="modal-header">
        <h5 class="modal-title" id="FileRestoreModal">Restore File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        Confirm to restore this file <span class="fn"></span> ?
        <input type="hidden" name="id" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmButton">Restore</button>
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
                $.get("{{ url('/fetch_all_archive_files') }}",  function(data){
                    console.log(data);
                    var filehtml = '';
                    $('.show_files').empty();
                    if(data.data.length > 0) {
                        $.each( data.data, function( key, val ) {
                            filehtml += '<div class="col-12 col-md-4 col-lg-4"> <div class="card shadow rouded p-3"> <div class="card-header"><h6>Name : '+val.name+'</h6><h6>Case Id : '+val.caseId+'</h6><hr></div> <div class="d-flex justify-content-between"> <h5>'+val.title+'</h5> <a href="'+val.filepath+'" class="btn btn-success btn-sm" target="_blank">Open</a> <button class="btn btn-danger btn-sm" type="button" data-id="'+val.id+'" data-title="'+val.title+'" data-toggle="modal" data-target="#FileRestoreModal">Restore</button> </div> </div> </div>';
                        });
                    } else {
                        filehtml = '<h5 class="p-5 text-danger"> No Files Found </h5>';
                    }
                    
                    $('.show_files').html(filehtml);
                });
            }
        

        $('#FileRestoreModal').on('show.bs.modal', function(e) { //#areas_modal model id which will be open onclick add button ,this is in blade file 
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('title');
            $(e.currentTarget).find('input[name="id"]').val(id);
            $('.fn').html('<strong class="text-info">'+name+'</strong>'); //name of input which are on blade file
        });

        $('#confirmButton').click(function() {
            var formData = new FormData($('#RestoreForm')[0]);
            
            $.ajax({
                url: "{{ url('/restorepateintFile') }}", // Replace with the URL where your server handles the file upload
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success == 200) {
                        $('#FileRestoreModal').modal('toggle');
                        show_files();
                        swal({
                            title: "File Restore",
                            text: response.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK!",
                            closeOnConfirm: true
                        });
                    } else {
                        swal({
                            title: "File Restore Failed",
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