<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$item = $_GET['keyword'];

//search for customers
$search_for_stocks = $fetch_data->search("SELECT Warehouse_Stock.id, Item.name AS item_name, Category.name AS category_name, quantity, expiry_date FROM Warehouse_Stock JOIN Item ON Item.id = Warehouse_Stock.item_id JOIN Category ON Category.id = Warehouse_Stock.category_id WHERE Item.name LIKE '%$item%' OR Category.name LIKE '%$item%' ORDER BY Warehouse_Stock.id ASC", $item);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Search Result</title>

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
                    <div class="col-md-10">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Search Result</h4>
                                <p class="category">You've searched for: <?php echo $_GET['keyword']; ?> </p>
                                <p class="text-right"><a href="./stock.php" class="btn btn-primary"><i class="fa fa-reply"></i> Go back</a></p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Available QTY</th>
                                        <th>Expiry Date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($search_for_stocks as $result): ?>
                                        <tr>
                                            <td><?php echo $result->item_name; ?></td>
                                            <td><?php echo $result->category_name; ?></td>
                                            <td><?php echo $result->quantity; ?></td>
                                            <td><?php echo $result->expiry_date; ?></td>
                                            <td>
                                                 <a href="request_stock.php?id=<?php echo $result->id; ?>">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($search_for_stocks)) { ?>
                                        <tr>
                                            <td colspan="3"><h2 class="text-center text-danger">No result found!</h2></td>
                                        </tr>
                                    <?php } ?> 
                                    </tbody>
                                </table>
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
