<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: requests.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$selected_request = $fetch_data->getSingleItem("SELECT item_id, category_id, client_id", 'Client_Stock_Request', 'id', $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Send Notice</title>

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
                                <h4 class="title">Send Notice</h4>
                                <p class="category">Notify client item is ready</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/admin_send_notice.php">
                                <input type="hidden" name="personnel_id" value="<?php echo $_SESSION['admin']; ?>" required>
                                <input type="hidden" name="item_id" value="<?php echo $selected_request->item_id; ?>" required>
                                <input type="hidden" name="category_id" value="<?php echo $selected_request->category_id; ?>" required>
                                <input type="hidden" name="client_id" value="<?php echo $selected_request->client_id; ?>" required>
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" name="title" placeholder ="" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea rows="5" class="form-control" name="content" placeholder="" required></textarea>
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
        <?php include 'includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include 'includes/scripts.php'; ?>

</html>
