<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: daily_requests.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$selected_item = $fetch_data->getSingleItem("SELECT item_id, category_id", 'Client_Stock_Request', 'id', $_GET['id']);

//check whether there is stock for selected request
$check_request = $fetch_data->compareTwoItems("SELECT id, quantity", 'Warehouse_Stock', 'item_id', $selected_item->item_id, 'category_id', $selected_item->category_id);

$item_details = $fetch_data->getSingleJoinItem("SELECT Item.name AS item_name, item_id, Category.name AS category_name, category_id, quantity, Request_Status.name AS request_status, Company.name AS client, client_id", 'Client_Stock_Request', "JOIN Item ON Item.id = Client_Stock_Request.item_id JOIN Category ON Category.id = Client_Stock_Request.category_id JOIN Company ON Company.id = Client_Stock_Request.client_id JOIN Request_Status ON Request_Status.id = Client_Stock_Request.status", "Client_Stock_Request.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Release Stock</title>

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

                <?php include 'includes/alert.php'; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Stock Details</h4>
                                <p class="category">Available Stock
                                    <?php
                                        if (!empty($check_request)) {
                                            ?>
                                            (<b><?php echo $check_request->quantity; ?></b>)
                                            <?php
                                        }
                                    ?>
                                </p>
                            </div>
                            <div class="content">
                                <?php
                                    if (empty($check_request)) {
                                        //no stock relating to requested item
                                        ?>
                                        <span style="color: red;">No stock relating to client request</span>
                                        <p><a href="daily_requests.php">&laquo; Back</a></p>
                                        <?php
                                    } else {
                                        ?>
                                        <form method="POST" action="../Submits/admin_release_stock.php">
                                            <input type="hidden" name="personnel_id" value="<?php echo $_SESSION['admin']; ?>" required>
                                            <input type="hidden" name="item_id" value="<?php echo $item_details->item_id; ?>" required>
                                            <input type="hidden" name="client_id" value="<?php echo $item_details->client_id; ?>" required>
                                            <input type="hidden" name="category_id" value="<?php echo $item_details->category_id; ?>" required>
                                            <input type="hidden" name="requested_quantity" value="<?php echo $item_details->quantity; ?>" required>
                                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                            <input type="hidden" name="stock_quantity" value="<?php echo $check_request->quantity; ?>" required>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Item</label>
                                                        <input type="text" class="form-control" disabled value ="<?php echo $item_details->item_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Requested QTY</label>
                                                        <input type="number" class="form-control" disabled value ="<?php echo $item_details->quantity; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Category</label>
                                                        <input type="text" class="form-control" disabled value ="<?php echo $item_details->category_name; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Client</label>
                                                        <input type="text" class="form-control" disabled value ="<?php echo $item_details->client; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <input type="text" class="form-control" disabled value="<?php echo $item_details->request_status; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>QTY To Offer</label>
                                                        <input type="number" class="form-control" name="released_quantity" placeholder="" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Note</label>
                                                        <textarea rows="5" class="form-control" placeholder="A little note when requested quantity isn't met..." name="note"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Release Stock</button>
                                            <div class="clearfix"></div>
                                        </form>
                                        <?php
                                    }
                                ?>
                                
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
