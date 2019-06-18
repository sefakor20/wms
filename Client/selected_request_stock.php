<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

if (empty($_GET['id'])) {
    header('location: stock.php');
}

$selected_stock = $fetch_data->getSingleJoinItem("SELECT item_id, category_id, Item.name AS item_name, Category.name AS category_name, quantity", 'Client_Stock', "JOIN Item ON Item.id = Client_Stock.item_id JOIN Category ON Category.id = Client_Stock.category_id", "Client_Stock.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

	<title>Client - Request Stock</title>

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

                <?php include '../Warehouse/includes/alert.php'; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Stock Details</h4>
                                <p class="category">Remaining Quantity (<?php echo $selected_stock->quantity; ?>)</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/client_request_stock.php">
                                <input type="hidden" name="item_id" value="<?php echo $selected_stock->item_id; ?>" required>
                                <input type="hidden" name="category_id" value="<?php echo $selected_stock->category_id; ?>" required>
                                <input type="hidden" name="client_id" value="<?php echo $_SESSION['client_id']; ?>" required>
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Item</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo $selected_stock->item_name; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo $selected_stock->category_name; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>QTY</label>
                                                <input type="number" class="form-control" placeholder ="23" name="quantity" required>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Request Stock</button>
                                    <div class="clearfix"></div>
                                </form>
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
