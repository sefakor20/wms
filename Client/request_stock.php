<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$items = $fetch_data->fetchData('SELECT * FROM Item');
$categories = $fetch_data->fetchData('SELECT * FROM Category');

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
                                <p class="category">Requesting for new items that do not exist in stock</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/client_request_new_stock.php">
                                <input type="hidden" name="client_id" value="<?php echo $_SESSION['client_id']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Item</label>
                                                <select class="form-control" name="item_id" required>
                                                    <option value="">- choose  item name -</option>
                                                    <?php foreach($items as $item): ?>
                                                        <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="category_id" required>
                                                    <option value="">- choose category name -</option>
                                                    <?php foreach($categories as $cat): ?>
                                                        <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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
