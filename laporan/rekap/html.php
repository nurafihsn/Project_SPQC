<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            $.ajax({
                url: 'new.php',
                dataType: 'json',
                success: function(data) {
                    var dataTable = new google.visualization.DataTable();
                    dataTable.addColumn('string', data[0][0]);
                    dataTable.addColumn('number', data[0][1]);

                    for (var i = 1; i < data.length; i++) {
                        dataTable.addRow([data[i][0], data[i][1]]);
                    }

                    var options = {
                        title: 'LSF pada LSTG',
                        hAxis: {
                            title: 'TANGGAL',
                           
                        },
                        vAxis: {
                            title: 'lsf',
                            minValue: 0, // Set nilai minimum untuk sumbu Y
                            maxValue: 2000 // Set nilai maksimum untuk sumbu Y
                        }
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                    chart.draw(dataTable, options);
                },
                error: function(error) {
                    console.error("Error fetching data:", error);
                }
            });
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>
