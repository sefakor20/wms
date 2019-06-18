<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: waiting_approval.php');
}

$fetch_data = new Fetch($connection);

$selected_item = $fetch_data->getSingleJoinItem("SELECT Warehouse_Release_Stock.id, Item.name AS item_name, item_id, Category.name AS category_name, category_id, released_quantity, note, Warehouse_Release_Stock.created_at", 'Warehouse_Release_Stock', "JOIN Item ON Item.id = Warehouse_Release_Stock.item_id JOIN Category ON Category.id = Warehouse_Release_Stock.category_id", "Warehouse_Release_Stock.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

	<title>Client - Stock Details</title>

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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Stock Details</h4>
                                <p class="category">Available Stock</p>
                            </div>
                            <div class="content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Item</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_item->item_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" disabled value="<?php echo $selected_item->released_quantity; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Category</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_item->category_name; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        if (!empty($selected_item->note)) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Note</label>
                                                        <p>
                                                           <?php echo $selected_item->note; ?> 
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                    <a href="../Submits/client_approve.php?wrs_id=<?php echo $selected_item->id; ?>&client_id=<?php echo $_SESSION['client_id']; ?>&item_id=<?php echo $selected_item->item_id; ?>&category_id=<?php echo $selected_item->category_id; ?>&released_quantity=<?php echo $selected_item->released_quantity; ?>">Approve Stock</a>
                                    <!--<button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Release Stock</button>-->
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
