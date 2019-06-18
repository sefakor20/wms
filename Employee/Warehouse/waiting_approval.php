<?php
require_once '../../Core/init.php';

if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->getTotal('Supplier_Release_Stock', 'status', 1);
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

$items = $fetch_data->getPaginationRecords("SELECT Supplier_Release_Stock.id, Company.name AS supplier, supplier_id, Item.name AS item_name, item_id, Category.name AS category_name, category_id, released_quantity, Supplier_Release_Stock.created_at, expiry_date", 'Supplier_Release_Stock', "JOIN Company ON Company.id = Supplier_Release_Stock.supplier_id JOIN Item ON Item.id = Supplier_Release_Stock.item_id JOIN Category ON Category.id = Supplier_Release_Stock.category_id", "Supplier_Release_Stock.status", 1, $rows, $offset);

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

	<title>Employee - Stock Waiting Approval</title>

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
                                <h4 class="title">Stock(s) Waiting Approval</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Supplier</th>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Date/Time</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($items as $item): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $item->supplier; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $item->item_name; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $item->category_name; ?></td>
                                            <td><?php echo $item->released_quantity; ?></td>
                                            <td><?php echo $date_format->getDate($item->created_at) ?></td>
                                            <td><a href="waiting_approval_stock_detail.php?id=<?php echo $item->id; ?>">Details</a> | 
                                            <a href="../../Submits/employee_approves.php?wa_id=<?php echo $item->id; ?>&personnel_id=<?php echo $_SESSION['gen_user']; ?>&item_id=<?php echo $item->item_id; ?>&category_id=<?php echo $item->category_id; ?>&released_quantity=<?php echo $item->released_quantity; ?>&expiry=<?php echo $item->expiry_date; ?>&supplier_id=<?php echo $item->supplier_id; ?>">Approve Stock</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="waiting_approval.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="waiting_approval.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
