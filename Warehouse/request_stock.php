<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('stock.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$suppliers = $fetch_data->getMultiItem("SELECT id, name", "Company", "user_group", 1);
$selected_stock = $fetch_data->getSingleJoinItem("SELECT item_id, category_id, Item.name AS item_name, Category.name AS category_name, quantity", 'Warehouse_Stock', "JOIN Item ON Item.id = Warehouse_Stock.item_id JOIN Category ON Category.id = Warehouse_Stock.category_id", "Warehouse_Stock.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Request Stock</title>

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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Stock Details</h4>
                                <p class="category">Requesting for Stock from supplier</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/admin_request_stock.php">
                                    <input type="hidden" name="personnel_id" value="<?php echo $_SESSION['admin']; ?>" required>
                                    <input type="hidden" name="item_id" value="<?php echo $selected_stock->item_id; ?>" required>
                                    <input type="hidden" name="category_id" value="<?php echo $selected_stock->category_id; ?>" required>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Item</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_stock->item_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Available QTY</label>
                                                <input type="number" class="form-control" disabled value="<?php echo $selected_stock->quantity; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Category</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_stock->category_name; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <select class="form-control" name="supplier_id" required>
                                                    <option value="">- choose supplier name -</option>
                                                    <?php foreach($suppliers as $sup): ?>
                                                        <option value="<?php echo $sup->id; ?>"><?php echo $sup->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>QTY To Request</label>
                                                <input type="number" class="form-control" placeholder="" name="quantity" required>
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
        <?php include 'includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include 'includes/scripts.php'; ?>

</html>
