<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');

    // $user = $_SESSION(['user']); 

    include('database/po_status_pie_graph.php');
    include('database/supplier_product_bar_graph.php');
    // var_dump($results);
    // die;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IMS DeskBoard</title>
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css" />
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>

<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar -->
        <?php include('sidebar/appsidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('sidebar/apptopbar.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="col50">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                            <p class="highcharts-description">
                                Here is the breakdown of the purchase orders by status.
                            </p>
                        </figure>
                    </div>
                    <div class="col50">
                        <figure class="highcharts-figure">
                            <div id="containerBarChart"></div>
                            <p class="highcharts-description">
                                Here is the breakdown of the purchase orders by status.
                            </p>
                        </figure>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    </div>



<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    var graphData = <?= json_encode($results) ?>;
    // Data retrieved from https://netmarketshare.com
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Purchase Order By Status',
            align: 'left'
        },
        tooltip: {
            // pointFormat: '{series.name}: <b>{point.percentage}</b>'
            pointFormatter: function(){
                var point = this,
                    series = point.series;
                
                return `<b>${series.name}</b> : ${point.y}`
            }
        },  
        plotOptions: {
            pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage}'
                }
            }
        },
        series: [{
            name: 'Status',
            colorByPoint: true,
            data: graphData
        }]
        });




    var barGraphData = <?= json_encode($bar_chart_data)?>;
    var barGraphCategories = <?= json_encode($categories)?>;

    console.log(barGraphData, barGraphCategories);
    Highcharts.chart('containerBarChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Product Count Assigned To Supplier'
        },
        xAxis: {
            categories: barGraphCategories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
            text: 'Product Count'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span>',
            pointFormatter: function(){
                var point = this,
                    series = point.series;

                    console.log(series);
                    console.log(point);
                return `<b>${point.category}</b> : ${point.y}`
            }
        },
        plotOptions: {
            column: {
            pointPadding: 0.2,
            borderWidth: 0
            }
        },
        series: [{
            name: 'Suppliers',
            data: barGraphData
        }]
        });
</script>
</body>

</html>