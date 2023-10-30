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
                            <h5>Patient History</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Patient History</a></li>
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

                                        <div class="row ">
                                            <div class="col-12 col-md-6 col-xl-6">
                                                <h6>Patient: {{ $Customer->name }}</h6>
                                                <h6>Mobile: {{ $Customer->mobile }}</h6>
                                                <h6>Email:  @if(!@empty($Customer->email)) {{ $Customer->email }} @else NA @endif </h6> 
                                                <h6>CaseID: {{ $custId }}</h6>
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-6">
                                                <h6>Gender:  @if(!@empty($Customer->gender)) {{ $Customer->gender }} @else NA @endif </h6> 
                                                <h6>Age:  @if(!@empty($Customer->age)) {{ $Customer->age }} @else NA @endif </h6>
                                                <h6>Address:  @if(!@empty($Customer->address)) {{ $Customer->address }} @else NA @endif </h6>
                                                <h6>Ethnicity:  @if(!@empty($Customer->ethnicity)) {{ $Customer->ethnicity }} @else NA @endif </h6>
                                            </div>
                                            <div class="col-12">
                                            @if(!empty($Customer->caseId)) 
                                                <a href='/directory/{{$Customer->caseId}}'
                                                    class='btn waves-effect waves-light btn-success' title='Directory'><i class="feather icon-folder"></i></a>
                                            @endif
                                            <a href='/customers/editCustomer/{{ $Customer->id }}' class='btn waves-effect waves-light btn-primary' title='Edit'><i class="feather icon-edit"></i></a>
                
                                            </div>
                                            <div class="col-12">
                                                <hr>
                                                <div class="table-responsive">
                                                    <table class="table table-striped thead-dark table-bordered dt-responsive dataTable" id="patient_history">
                                                        <thead>
                                                            <tr>
                                                                <th>CaseId</th>
                                                                <th>Doctor</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Fees</th>
                                                                <th>Balance</th>
                                                                <th>Payment Mode</th>
                                                                <th>Online</th>
                                                                <th>Folloup Booked</th>
                                                                <th>Remark</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $fees = []; $bal = []; ?>
                                                            @foreach($Bookings as $bk) 
                                                                <tr>
                                                                    <td>{{ $bk->caseId }}</td>
                                                                    <td>{{ $bk->doctor }}</td>
                                                                    <td>{{ date("d-m-Y", strtotime($bk->dtStart)) }}</td>
                                                                    <td>{{ date("H:i:s", strtotime($bk->aTime)) }}</td>
                                                                    <td>{{ $bk->feeAmount }}</td>
                                                                    <?php $fees[] = $bk->feeAmount; ?>
                                                                    <td>{{ $bk->balancePayment }}</td>
                                                                    <?php $bal[] = $bk->balancePayment; ?>
                                                                    <td>{{ $bk->paymentMode }}</td>
                                                                    <td>@if($bk->isOnline == 0) No @else Yes @endif</td>
                                                                    <td>{{ $bk->folloupBooked }}</td>
                                                                    <td>{{ $bk->remarks }}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr class="text-white bg-dark">
                                                                <td colspan="4" class="text-center">Total Fees and Balance Amount</td>  
                                                                <td>{{ array_sum($fees) }}</td>
                                                                <td>{{ array_sum($bal) }}</td>
                                                                <!-- <td></td> -->
                                                            </tr>
                                                        </tbody>
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
            </div>
        </div>
    </div>
    </div>


</div>

@endsection

@section('scripts')


<script>
    
</script>


@endsection