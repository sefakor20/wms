<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['sup_id'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: index.php');
}

$fetch_data = new Fetch($connection);

$selected_item = $fetch_data->getSingleItem("SELECT item_id, category_id", 'Warehouse_Stock_Request', 'id', $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
    
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

    <title>Supplier - Send Notice</title>

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
                                <h4 class="title">Send Notice</h4>
                                <p class="category">Notify client about selected request</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/supplier_send_notice.php">
                                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                    <input type="hidden" name="item_id" value="<?php echo $selected_item->item_id; ?>" required>
                                    <input type="hidden" name="category_id" value="<?php echo $selected_item->category_id; ?>" required>
                                    <input type="hidden" name="supplier_id" value="<?php echo $_SESSION['sup_id']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" placeholder ="" name="title" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea rows="5" class="form-control" placeholder="" name="content" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Send Notice</button>
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
