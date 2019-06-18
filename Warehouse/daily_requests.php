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
$pagination = $fetch_data->dailyTotalWarehouse('Client_Stock_Request', $from, $to);

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

$requests = $fetch_data->getDailyItems("SELECT Client_Stock_Request.id, Item.name AS item_name, Category.name AS category_name, quantity, Request_Status.name AS notice, Client_Stock_Request.status, Company.name AS client, Client_Stock_Request.created_at", 'Client_Stock_Request', "JOIN Item ON Item.id = Client_Stock_Request.item_id JOIN Category ON Category.id = Client_Stock_Request.category_id JOIN Company ON Company.id = Client_Stock_Request.client_id JOIN Request_Status ON Request_Status.id = Client_Stock_Request.status", 'Client_Stock_Request', $from, $to, $rows, $offset);

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

	<title>Admin - Daily Requests</title>

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
                                <h4 class="title">Daily Requests</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Client</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($requests as $req): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $req->item_name; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $req->category_name; ?></td>
                                            <td><?php echo $req->quantity; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $req->client; ?></td>
                                            <td><?php echo $req->notice; ?></td>
                                            <td><?php echo $date_format->getDate($req->created_at) ?></td>
                                            <td>
                                            <?php
                                                if ($req->status != 3) {
                                                    ?>
                                                    <a href="release_stock.php?id=<?php echo $req->id; ?>">Release Stock</a> | <a href="send_notice.php?id=<?php echo $req->id; ?>">Send Notice</a>
                                                    <?php
                                                }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="daily_requests.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="daily_requests.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
