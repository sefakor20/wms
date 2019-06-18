<?php
require_once '../../Core/init.php';

if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

$fetch_data = new Fetch($connection);

$requests = $fetch_data->getTotal('Client_Stock_Request', 'status', 1);
$waiting_approval = $fetch_data->getTotal('Supplier_Release_Stock', 'status', 1);
$attendance_reports = $fetch_data->paginationTotal('Employee_Report');
$notices = $fetch_data->getTotal('Supplier_Notice', 'notice_status', 2);

//alert for remaining items
include 'includes/danger_alert.php';

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Employee - Home</title>

	<?php include 'includes/links.php'; ?>

</head>
<body>

<div class="wrapper">
    
    <!-- side bar -->
    <?php include 'includes/side_bar.php'; ?>

    <div class="main-panel">
        
        <!-- navigation -->
        <?php include 'includes/nav.php'; ?>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $requests->total; ?></h4>
                                <p class="category"><b>Pending</b> Request(s)</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="requests.php">Open</a>
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $notices->total; ?></h4>
                                <p class="category"><b>New Notice(s)</b></p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="new_notice.php">Open</a>
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $waiting_approval->total; ?></h4>
                                <p class="category">Stock(s) Awaiting Approval</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="waiting_approval.php">Open</a>
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $attendance_reports; ?></h4>
                                <p class="category">Attendance Reports</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="attendance_reports.php">Open</a>
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- footer -->
        <?php include '../../Warehouse/includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include '../../Warehouse/includes/scripts.php'; ?>

</html>
