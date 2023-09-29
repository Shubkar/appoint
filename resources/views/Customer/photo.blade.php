@extends('layouts.app')
@section('contents')

<div class="pcoded-content">
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Capture Photo</h5>
                            <span>Capture Patient Photo</span>
                        </div>
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


                                    <form method="POST" action="{{ route('webcam_capture') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="my_camera"></div>
                                                <br/>
                                                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                                <input type="hidden" name="image" class="image-tag">
                                                <input type="hidden" name="cust_id" value="{{ $custId }}">
                                            </div>

                                            <div class="col-md-6">
                                                <div id="results">Your captured image will appear here...</div>
                                            </div>

                                            <div class="col-md-12 text-center">
                                                <br/>
                                                <button class="btn btn-success">Submit</button>
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
    </div>


</div>



@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
<script>
    
    $(document).ready(function() {

            Webcam.set({
                width: 490,
                height: 350,
                image_format: 'jpeg',
                jpeg_quality: 90
            });

            Webcam.attach( '#my_camera' );
    });
    
</script>


@endsection