@extends('layouts.app')
@section('headerScripts')



    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">


    <style>

        .fixedHeader-floating
        {
            top:63px !important;
            z-index:9999;
        }

        .btn i {
            margin: 0px !important;
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
                            <h5>Expense</h5>
                            <span>Manage Expense</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="/home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Manage Expense</a></li>
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

                        @if(session('success'))
                            <div class="col-12">
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="col-12">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        



                            <div class="col-md-12 col-xl-12 col-sm-12">
                                <div class="card sale-card">
                                    <div class="card-header row">
                                        <div class="col-sm-12 col-md-6">
                                        <h5>Expenses</h5>
                                        </div>
                                        <div class="col-sm-12 col-md-6" style="text-align: right;">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ExpenseModal">Add Expense</button>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <table id="footer-search"
                                                   class="table table-striped table-bordered dt-responsive dataTable display select"
                                                   role="grid" aria-describedby="footer-search_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Salary: activate to sort column ascending">
                                                        User
                                                    </th>
                                                     <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Date
                                                    </th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="footer-search"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending">Title
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Description
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Age: activate to sort column ascending">Amount
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        Paid to
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        Reference
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="footer-search"
                                                        aria-label="Office: activate to sort column ascending">
                                                        File
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($expenses as $row)
                                                    <tr>
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ date("d-m-Y", strtotime($row->expense_date)) }}</td>
                                                        <td>{{ $row->expense_title }}</td>
                                                        <td>{{ $row->description }}</td>
                                                        <td>{{ $row->amount }}</td>
                                                        <td>{{ $row->paid_to }}</td>
                                                        <td>{{ $row->reference }}</td>
                                                        <td>@if(!empty($row->file))<a href="{{ $row->file }}" target="_blank">View</a> @else NA @endif</td>
                                                    </tr>
                                                    @endforeach
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


    <!-- Modal -->
<div class="modal fade" id="ExpenseModal" tabindex="-1" role="dialog" aria-labelledby="ExpenseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ExpenseModalLabel">Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
      <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="user">User</label>
                    <select name="user" id="user" class="form-control">
                        <option selected disbaled hidden>Select User</option>
                        @foreach ($users as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                            <label for="expense_date">Date</label>
                            <input id="expense_date" type="date" class="form-control" name="expense_date"  required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="expense_title">{{ __('Expense Title') }}</label>
                            <input id="expense_title" type="text" class="form-control" name="expense_title" required>
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control" name="description" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="amount">{{ __('Amount') }}</label>
                            <input id="amount" type="text" class="form-control" name="amount"  required>
                        </div>

                        <div class="form-group">
                            <label for="paid_to">{{ __('Paid To') }}</label>
                            <input id="paid_to" type="text" class="form-control" name="paid_to"  required>
                        </div>

                        <div class="form-group">
                            <label for="reference">{{ __('Reference') }}</label>
                            <input id="reference" type="text" class="form-control" name="reference" required>
                        </div>

                        <div class="form-group">
                            <label for="file">{{ __('Upload File') }}</label>
                            <input id="file" type="file" class="form-control" name="file">
                        </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      </form>
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

@endsection