<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['sup_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$pending_requests = $fetch_data->getTwoFieldsTotal('Warehouse_Stock_Request', 'supplier_id', $_SESSION['sup_id'], 'request_status', 1);
$incomplete_requests = $fetch_data->getTwoFieldsTotal('Warehouse_Stock_Request', 'supplier_id', $_SESSION['sup_id'], 'request_status', 2);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

	<title>Supplier - Home</title>

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
                                <h4 class="title"><?php echo $pending_requests->total; ?></h4>
                                <p class="category">Request(s) <b>Pending</b></p>
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
                                <h4 class="title"><?php echo $incomplete_requests->total; ?></h4>
                                <p class="category"><b>Incomplete</b> requests</p>
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
