<?php
require_once '../../Core/init.php';

if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->paginationTotal('Warehouse_Stock');
$total = $pagination;

$page = (int)$_GET['page'];
$rows = 30;

if($page < 1) {
    $page = 1;
}

$pages = ceil($pagination / $rows);

if(($page > $pages) && ($pages > 1)) {
    $page = $pages;
}

$offset = ($page -1) * $rows;

$stocks = $fetch_data->getItemsWithLimitOffset("SELECT Warehouse_Stock.id, Item.name AS item_name, Category.name AS category_name, quantity, expiry_date", 'Warehouse_Stock', "JOIN Item ON Item.id = Warehouse_Stock.item_id JOIN Category ON Category.id = Warehouse_Stock.category_id", $rows, $offset);

if(($page - 1) >= 1) {
    $prevPage = $page - 1;
} else {
    $prevPage = 1;
}

//getting next page value
if(($page + 1) <= $pages) {
    $nextPage = $page + 1;
} else {
    $nextPage = $pages;
}

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Employee - Stock</title>

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

                <?php include '../../Warehouse/includes/alert.php'; ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Stock</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Available QTY</th>
                                        <th>Expiry Date</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($stocks as $stock): ?>
                                            <tr>
                                                <td style="text-transform: capitalize;"><?php echo $stock->item_name; ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $stock->category_name; ?></td>
                                                <td><?php echo $stock->quantity; ?></td>
                                                <td><?php echo $stock->expiry_date; ?></td>
                                                <td><a href="request_stock.php?id=<?php echo $stock->id; ?>">Request Stock</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="all_stock.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="all_stock.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
                                    <?php endif; ?>
                                </ul>

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
