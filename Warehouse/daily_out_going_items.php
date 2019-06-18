<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$from = date('Y-m-d 00:00:00');
$to = date('Y-m-d 23:59:59');
$pagination = $fetch_data->dailyTotalWarehouse('Warehouse_Release_Stock', $from, $to);

$total = $pagination->total;

$page = (int)$_GET['page'];
$rows = 30;

if($page < 1) {
    $page = 1;
}

$pages = ceil($pagination->total / $rows);

if(($page > $pages) && ($pages > 1)) {
    $page = $pages;
}

$offset = ($page -1) * $rows;

$stocks = $fetch_data->getDailyItems("SELECT Item.name AS item_name, Category.name AS category_name, released_quantity, CONCAT(User.first_name, ' ', User.last_name, ' ', User.other_name) AS personnel, Warehouse_Release_Stock.status, Company.name AS client, Warehouse_Release_Stock.created_at", 'Warehouse_Release_Stock', "JOIN Item ON Item.id = Warehouse_Release_Stock.item_id JOIN Category ON Category.id = Warehouse_Release_Stock.category_id JOIN User ON User.id = Warehouse_Release_Stock.personnel_id JOIN Company ON Company.id = Warehouse_Release_Stock.client_id", "Warehouse_Release_Stock", $from, $to, $rows, $offset);

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

	<title>Admin - Daily Outgoing Items</title>

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Daily Outgoing Items</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Personnel</th>
                                        <th>Client</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($stocks as $stock): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $stock->item_name; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $stock->category_name; ?></td>
                                            <td><?php echo $stock->released_quantity; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $stock->personnel; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $stock->client; ?></td>
                                            <?php
                                                if ($stock->status == 1) {
                                                    ?>
                                                    <td>Pending Approval</td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td>Approved</td>
                                                    <?php
                                                }
                                            ?>
                                            <td><?php echo $date_format->getDate($stock->created_at) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="daily_out_going_items.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="daily_out_going_items.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
                                    <?php endif; ?>
                                </ul>

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
