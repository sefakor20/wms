<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['sup_id'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: all_requests.php');
}

$fetch_data = new Fetch($connection);

$selected_stock = $fetch_data->getSingleJoinItem("SELECT Item.name AS item, item_id, Category.name AS category, category_id, quantity", 'Warehouse_Stock_Request', "JOIN Item ON Item.id = Warehouse_Stock_Request.item_id JOIN Category ON Category.id = Warehouse_Stock_Request.category_id", "Warehouse_Stock_Request.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
    
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

    <title>Supplier - Release Stock</title>

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
                                <p class="category">Releasing Stock to client</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/supplier_release_stock.php">
                                    <input type="hidden" name="supplier_id" value="<?php echo $_SESSION['sup_id']; ?>" required>
                                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                    <input type="hidden" name="item_id" value="<?php echo $selected_stock->item_id; ?>" required>
                                    <input type="hidden" name="category_id" value="<?php echo $selected_stock->category_id; ?>" required>
                                    <input type="hidden" name="requested_quantity" value="<?php echo $selected_stock->quantity; ?>" required>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Item</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_stock->item; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Requested QTY</label>
                                                <input type="number" class="form-control" disabled value="<?php echo $selected_stock->quantity; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Category</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_stock->category; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>QTY To Release</label>
                                                <input type="number" class="form-control" placeholder="100" name="released_quantity" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Expiry Date</label>
                                                <input type="date" class="form-control" name="expiry_date" required>
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
