<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['sup_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

$pagination = $fetch_data->getTotal('Warehouse_Stock_Request', 'supplier_id', $_SESSION['sup_id']);
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

$all_requests = $fetch_data->getPaginationRecords("SELECT Warehouse_Stock_Request.id, request_status, Item.name AS item, Category.name AS category, quantity, Request_Status.name AS r_status, Warehouse_Stock_Request.created_at", 'Warehouse_Stock_Request', "JOIN Item ON Item.id = Warehouse_Stock_Request.item_id JOIN Category ON Category.id = Warehouse_Stock_Request.category_id JOIN Request_Status ON Request_Status.id = Warehouse_Stock_Request.request_status", 'supplier_id', $_SESSION['sup_id'], $rows, $offset);

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
    
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

    <title>Supplier - All Requests</title>

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">All Requests</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($all_requests as $req): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $req->item; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $req->category; ?></td>
                                            <td><?php echo $req->quantity; ?></td>
                                            <td><?php echo $req->r_status; ?></td>
                                            <td><?php echo $date_format->getDate($req->created_at) ?></td>
                                            <td>
                                            <?php
                                                if ($req->request_status != 3) {
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
                                      <li><a href="all_requests.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="all_requests.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
                                    <?php endif; ?>
                                </ul>

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
