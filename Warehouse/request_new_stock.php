<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$items = $fetch_data->fetchData('SELECT * FROM Item');
$categories = $fetch_data->fetchData('SELECT * FROM Category');
$suppliers = $fetch_data->getMultiItem("SELECT id, name", "Company", "user_group", 1);

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

                <?php include 'includes/alert.php'; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Stock Details</h4>
                                <p class="category">Requesting for new items that do not exist in stock</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/admin_request_new_stock.php">
                                    <input type="hidden" name="personnel_id" value="<?php echo $_SESSION['admin']; ?>" required>
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
                                        <div class="col-md-5">
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <select class="form-control" name="supplier_id" required>
                                                    <option value="">- choose supplier -</option>
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
