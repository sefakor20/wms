<?php
require_once '../../Core/init.php';
if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

if (empty($_GET['id'])) {
    header('location: waiting_approval.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$selected_item = $fetch_data->getSingleJoinItem("SELECT Supplier_Release_Stock.id, Company.name AS supplier, supplier_id, Item.name AS item_name, item_id, Category.name AS category_name, category_id, released_quantity, Supplier_Release_Stock.created_at, expiry_date, Supplier_Release_Stock.note", 'Supplier_Release_Stock', "JOIN Company ON Company.id = Supplier_Release_Stock.supplier_id JOIN Item ON Item.id = Supplier_Release_Stock.item_id JOIN Category ON Category.id = Supplier_Release_Stock.category_id", "Supplier_Release_Stock.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Employee - Stock Details</title>

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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_item->supplier; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Expiry Date</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_item->expiry_date; ?>">
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

                                    <a href="../../Submits/employee_approves.php?wa_id=<?php echo $selected_item->id; ?>&personnel_id=<?php echo $_SESSION['gen_user']; ?>&item_id=<?php echo $selected_item->item_id; ?>&category_id=<?php echo $selected_item->category_id; ?>&released_quantity=<?php echo $selected_item->released_quantity; ?>&expiry=<?php echo $selected_item->expiry_date; ?>&supplier_id=<?php echo $selected_item->supplier_id; ?>" class="btn btn-info btn-fill pull-right">Approve Stock</a>
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
        <?php include '../../Warehouse/includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include '../../Warehouse/includes/scripts.php'; ?>

</html>
