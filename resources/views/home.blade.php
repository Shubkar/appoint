@extends('layouts.app')
@section('headerScripts')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/files/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
@endsection
@section('contents')
    <div class="pcoded-content">

        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Dashboard</h5>
                            <span>Appointments Booked</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
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
                                        <h5>Membership Analytics</h5>
                                    </div>
                                    <div class="card-block">
                                        <div id="sales-analytics" class="chart-shadow"
                                             style="height:380px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--<div class="row">

                            <div class="col-md-12 col-xl-12">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h5>Today's Appointments</h5>
                                    </div>
                                    <div class="card-block">
                                        <table id="footer-search" class="table table-striped table-bordered nowrap dataTable"
                                               role="grid" aria-describedby="footer-search_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending">Voter Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending">Entered
                                                    Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-label="Office: activate to sort column ascending">Mobile Number
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-label="Age: activate to sort column ascending">EPIC
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-label="Start date: activate to sort column ascending">Assembly
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-label="Salary: activate to sort column ascending">Cast
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1"
                                                    colspan="1" aria-label="Salary: activate to sort column ascending">Profession
                                                </th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            --}}{{--<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="footer-search" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 145px;">Name</th><th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 191.4px;">Position</th><th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 137.8px;">Office</th><th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 138.6px;">Age</th><th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 138.6px;">Start date</th><th class="sorting" tabindex="0" aria-controls="footer-search" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 139.6px;">Salary</th></tr>--}}{{--
                                            <tr>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Name"></th>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Position"></th>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Office"></th>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Age"></th>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Start date"></th>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Salary"></th>
                                                <th rowspan="1" colspan="1"><input type="text" class="form-control"
                                                                                   placeholder="Search Salary"></th>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>--}}




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')

    <script src="/files/bower_components/chartist/js/chartist.js" type="text/javascript"></script>

    <script src="/files/assets/pages/widget/amchart/amcharts.js" type="text/javascript"></script>
    <script src="/files/assets/pages/widget/amchart/serial.js" type="text/javascript"></script>
    <script src="/files/assets/pages/widget/amchart/light.js" type="text/javascript"></script>

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

    <script type="text/javascript" src="/files/assets/js/script.min.js"></script>




    <script>

        function floatchart() {
            var e = {
                    legend: {show: !1},
                    series: {
                        label: "",
                        curvedLines: {
                            active: !0,
                            nrSplinePoints: 20
                        }
                    },
                    tooltip: {
                        show: !0,
                        content: "x : %x | y : %y"
                    },
                    grid: {
                        hoverable: !0,
                        borderWidth: 0,
                        labelMargin: 0,
                        axisMargin: 0,
                        minBorderMargin: 0
                    },
                    yaxis: {
                        min: 0,
                        max: 30,
                        color: "transparent",
                        font: {size: 0}
                    },
                    xaxis: {
                        color: "transparent",
                        font: {size: 0}
                    }
                },
                a = {
                    legend: {show: !1},
                    series: {
                        label: "",
                        curvedLines: {
                            active: !0,
                            nrSplinePoints: 20
                        }
                    },
                    tooltip: {
                        show: !0,
                        content: "x : %x | y : %y"
                    },
                    grid: {
                        hoverable: !0,
                        borderWidth: 0,
                        labelMargin: 0,
                        axisMargin: 0,
                        minBorderMargin: 8
                    },
                    yaxis: {
                        min: 0,
                        max: 30,
                        color: "transparent",
                        font: {size: 0}
                    },
                    xaxis: {
                        color: "transparent",
                        font: {size: 0}
                    }
                };
        }

        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            /*$('#footer-search tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#footer-search').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/getRegisteredUsers",
                "columns": [
                    {"data": "vname"},
                    {"data": "enteredName"},
                    {"data": "mobileNumber"},
                    {"data": "epic"},
                    {"data": "assembly"},
                    {"data": "voterCast"},
                    {"data": "voterProfession"},
                ],
                "deferRender": true
            });
            // Apply the search
            table.columns().every(function () {
                var that = this;

                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });*/

            //Chart
            floatchart(),

                $(window).on("resize",
                    function () {
                        floatchart()
                    }),

                $("#mobile-collapse").on("click",
                    function () {
                        setTimeout(function () {
                                floatchart()
                            },
                            700)
                    }),
                $(".scroll-widget").slimScroll({size: "5px", height: "290px", allowPageScroll: !1});
            var e = AmCharts.makeChart("sales-analytics",
                {
                    type: "serial",
                    theme: "light",
                    marginRight: 15,
                    marginLeft: 40,
                    autoMarginOffset: 20,
                    dataDateFormat: "YYYY-MM",
                    valueAxes: [{
                        id: "v1",
                        axisAlpha: 0,
                        position: "left",
                        ignoreAxisWidth: !0
                    }],
                    balloon: {
                        borderThickness: 1,
                        shadowAlpha: 0
                    },
                    graphs: [{
                        id: "g1",
                        balloon: {
                            drop: !0,
                            adjustBorderColor: !1,
                            color: "#ffffff",
                            type: "smoothedLine"
                        },
                        fillAlphas: .3,
                        bullet: "round",
                        bulletBorderAlpha: 1,
                        bulletColor: "#FFFFFF",
                        lineColor: "#4099ff",
                        bulletSize: 5,
                        hideBulletsCount: 50,
                        lineThickness: 3,
                        type: "smoothedLine",
                        title: "red line",
                        useLineColorForBulletBorder: !0,
                        valueField: "value",
                        balloonText: "<span style='font-size:18px;'>[[value]]</span>"
                    }],
                    chartCursor: {
                        valueLineEnabled: !0,
                        valueLineBalloonEnabled: !0,
                        cursorAlpha: 0,
                        zoomable: !1,
                        valueZoomable: !0,
                        valueLineAlpha: .5
                    },
                    chartScrollbar: {
                        autoGridCount: !0,
                        graph: "g1",
                        oppositeAxis: !0,
                        scrollbarHeight: 40
                    },
                    categoryField: "date",
                    categoryAxis: {
                        parseDates: !1,
                        dashLength: 1,
                        minorGridEnabled: !0
                    },
                    export: {enabled: !0},
                    dataProvider: [{date: "2012-06", value: 130},
                        {date: "2012-07", value: 100},
                        {date: "2012-08", value: 150},
                        {date: "2012-09", value: 125},
                        {date: "2012-10", value: 400},
                        {date: "2012-11", value: 850},
                        {date: "2012-12", value: 800},
                        {date: "2013-01", value: 1000}]
                });
            setTimeout(function () {
                e.zoomToIndexes(Math.round(.45 * e.dataProvider.length),
                    Math.round(.6 * e.dataProvider.length))
            }, 800)
        });

    </script>

    <script type="text/javascript">
        @if(isset($errMSg))
        @if($errMSg=="Success")
        swal({
            title: "Saved",
            text: "Info saved successfully!",
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