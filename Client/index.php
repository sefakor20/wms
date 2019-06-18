<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

//$pending_requests = $fetch_data->getTwoFieldsTotal('Client_Stock_Request', 'client_id', $_SESSION['client_id'], 'status', 1);
$incomplete_requests = $fetch_data->getTwoFieldsTotal('Client_Stock_Request', 'client_id', $_SESSION['client_id'], 'status', 2);
$new_notices = $fetch_data->getTwoFieldsTotal('Warehouse_Notice', 'client_id', $_SESSION['client_id'], 'notice_status', 2);
$all_requests = $fetch_data->getTotal('Client_Stock_Request', 'client_id', $_SESSION['client_id']);
$waiting_approval = $fetch_data->getTwoFieldsTotal('Warehouse_Release_Stock', 'client_id', $_SESSION['client_id'], 'status', 1);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

	<title>Client - Home</title>

	<?php include '../Warehouse/includes/links.php'; ?>

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
                                <h4 class="title"><?php echo $waiting_approval->total; ?></h4>
                                <p class="category"><b>Stock</b>(s) Awaiting approval</p>
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
                                <h4 class="title"><?php echo $incomplete_requests->total; ?></h4>
                                <p class="category"><b>Incomplete</b> requests</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="pending_stock.php">Open</a>
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
                                <h4 class="title"><?php echo $new_notices->total; ?></h4>
                                <p class="category">New <b>Notices</b></p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="new_notices.php">Open</a>
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
                                <h4 class="title"><?php echo $all_requests->total; ?></h4>
                                <p class="category">All Request(s)</p>
                            </div>
                            <div class="content">

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> <a href="all_requests.php">Open</a>
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
        <?php include '../Warehouse/includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include '../Warehouse/includes/scripts.php'; ?>

</html>
