@extends('layouts.app')
@section('headerScripts')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
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
                            <h5>Import CSV</h5>
                            <span>Import CSV</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Import CSV</a></li>
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
                                        <h5>Import CSV</h5>
                                    </div>
                                    <div class="card-block">
<form name="frmImport" id="frmImport" method="POST" action="/customers/postCSV" enctype="multipart/form-data">
    
    <input type="hidden" name="txtEmployee" id="txtEmployee" value="1" />
    {{-- <div class="form-group row">
        <div class="col-sm-3">
            <label for="employee" class="col-form-label">Select Doctor</label>
        </div>
        <div class="col-sm-9">
            <select name="txtEmployee" id="txtEmployee" class="select2 form-control">
                @foreach ($docs as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
    </div> --}}
    <div class="row">
                                             <label class="col-sm-3 col-form-label">CSV File</label>
                                                    <div class="col-sm-5">
                                                        <input type="file" name="csv_file" id="csv_file"
                                                                            class="form-control {{ $errors->has('csv_file') ? ' is-invalid' : '' }}" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                        <button type="submit"
                                                                                                    class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                                                Submit
                                                            </button>
                                                    </div>
                                        </div>
</form>
<div class="row">
    <div class="col-sm-12">
        <a href="https://appoint.ontimealways.com/sample.csv" target="_blank">Download Sample</a>
    </div>
</div>

                                        {{-- <div class="row"> --}}
                                            {{-- <form name="frmImport" id="frmImport" class="row" method="POST" action="/customers/postCSV" enctype="multipart/form-data">
                                                <div class="row form-group">
                                                   
                                                </div>
                                            </form> --}}
                                        {{-- </div> --}}
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
    <script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
     <!-- Select2 Files -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>




    <script>

        $(document).ready(function () {
            //$('.select2').select2();
        });

    </script>

    <script type="text/javascript">
        @if(isset($errMSg))
        @if($errMSg=="Success")
        swal({
            title: "Saved",
            text: "Patient Info saved successfully!",
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