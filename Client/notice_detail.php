<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: new_notice.php');
}

$fetch_data = new Fetch($connection);
$database = new Database($connection);

//change notice status from 'unread' to 'read'
$updated_at = date('Y:m:d H:i:s');
$database->update('Warehouse_Notice', $_GET['id'], array(
    'notice_status' => 1,
    'updated_at' => $updated_at     
));

$selected_notice = $fetch_data->getSingleJoinItem("SELECT Item.name AS item_name, Category.name AS category_name, title, content, Warehouse_Notice.created_at", 'Warehouse_Notice', "JOIN Item ON Item.id = Warehouse_Notice.item_id JOIN Category ON Category.id = Warehouse_Notice.category_id", "Warehouse_Notice.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

	<title>Client - Notice Details</title>

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
                                <h4 class="title" style="text-transform: capitalize;"><?php echo $selected_notice->title; ?></h4>
                                <p class="category" style="text-transform: capitalize;">Item: <?php echo $selected_notice->item_name; ?></p>
                                <p class="category" style="text-transform: capitalize;">Category: <?php echo $selected_notice->category_name; ?></p>
                            </div>
                            <div class="content">
                                <p><?php echo $selected_notice->content; ?></p>
                                <p><a href="new_notices.php">&laquo; Back</a></p>
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
