<html>
    <head>
        <title>Summary Report Loading</title>
    </head>
    <body>
        <script>
            var loadPg='{{$pgName}}';
            if(loadPg=='FeeReport')
            {
                window.location = "/feeReports/feeReport";
            }
            else
            {
                window.location = "/appointmentReports/index";
            }
    </script>
    </body>
</html>