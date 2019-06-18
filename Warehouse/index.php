<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$from = date('Y-m-d 00:00:00');
$to = date('Y-m-d 23:59:59');
$from_month = date('Y-m-d 00:00:00', strtotime('first day of this month'));
$to_month = date('Y-m-d 23:59:59', strtotime('last day of this month'));
$current_month_total_items = $fetch_data->dailyTotalWarehouse('Warehouse_All_Stock', $from_month, $to_month);
$current_month_total_outgoing_items = $fetch_data->dailyTotalWarehouse('Warehouse_Release_Stock', $from_month, $to_month);
$daily_incoming_items = $fetch_data->dailyTotalWarehouse('Warehouse_All_Stock', $from, $to);
$daily_outgoing_items = $fetch_data->dailyTotalWarehouse('Warehouse_Release_Stock', $from, $to);
$daily_requests = $fetch_data->dailyTotalWarehouse('Client_Stock_Request', $from, $to);
//$requests = $fetch_data->getTotal('Client_Stock_Request', 'status', 1);
$notices = $fetch_data->getTotal('Supplier_Notice', 'notice_status', 2);
$waiting_approval = $fetch_data->getTotal('Supplier_Release_Stock', 'status', 1);
$attendance_reports = $fetch_data->paginationTotal('Employee_Report');

//alert for remaining items
include 'includes/danger_alert.php';

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Home</title>

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
                                <h4 class="title"><?php echo $daily_incoming_items->total; ?></h4>
                                <p class="category">Daily Incoming Items</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="daily_incoming_items.php">Open</a>
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
                                <h4 class="title"><?php echo $daily_outgoing_items->total; ?></h4>
                                <p class="category">Daily Outgoing Items</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="daily_out_going_items.php">Open</a>
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
                                <h4 class="title"><?php echo $daily_requests->total; ?></h4>
                                <p class="category">Daily Request(s)</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="daily_requests.php">Open</a>
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
                                <p class="category">New Notice(s)</p>
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

                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php echo $current_month_total_items->total; ?></h4>
                                <p class="category">Monthly Incoming Items</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="monthly_incoming_items.php">Open</a>
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
                                <h4 class="title"><?php echo $current_month_total_outgoing_items->total; ?></h4>
                                <p class="category">Monthly Outgoing Item</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="monthly_outgoing_items.php">Open</a>
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
        <?php include 'includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include 'includes/scripts.php'; ?>

</html>
