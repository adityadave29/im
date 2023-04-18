<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');


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
            <!-- <div class="dashboard_content">
                <div class="dashboard_content_main"> -->
                    <div class="reportsContainer">
                      <div class ="box">
                        <div class = "reportType">
                          <p>Export products</p>
                          <div class = "alignRight">
                            <a class="reportExportBtn" href = "database/report_csv.php?report=product"> Excel</a>
                          </div>
                        </div>
                        <div class = "reportType">
                          <p>Export Suppliers</p>
                          <div class = "alignRight">
                            <a class="reportExportBtn" href = "database/report_csv.php?report=supplier"> Excel</a>
                          </div>
                        </div>    
                      </div>
                      <div class ="box">
                        <div class = "reportType">
                          <p>Export Deliveries</p>
                          <div class = "alignRight">
                            <a class="reportExportBtn" href = "database/report_csv.php?report=products"> Excel</a>
                          </div>
                        </div>
                        <div class = "reportType">
                          <p>Export Purchase Orders</p>
                          <div class = "alignRight">
                            <a class="reportExportBtn" href = "database/report_csv.php?report=products"> Excel</a>
                          </div>
                        </div>    
                      </div>
                    </div>
                </div>  
            <!-- </div>
        </div> -->
    </div>
    </div>



 
 
</body>

</html>