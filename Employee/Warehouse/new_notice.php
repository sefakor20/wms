<?php
require_once '../../Core/init.php';
if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->paginationTotal('Supplier_Notice');
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

$notices = $fetch_data->getItemsWithLimitOffset("SELECT Supplier_Notice.id, title, Company.name AS supplier, Notice_Status.name AS notice, notice_status, Supplier_Notice.created_at", 'Supplier_Notice', "JOIN Company ON Company.id = Supplier_Notice.supplier_id JOIN Notice_Status ON Notice_Status.id = Supplier_Notice.notice_status", $rows, $offset);

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

    <title>Employee - Notices</title>

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
                                <h4 class="title">All Notices</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Title</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($notices as $not): ?>
                                        <?php
                                            if ($not->notice_status == 2) {
                                                ?>
                                                <tr>
                                                    <td style="font-weight: bolder; text-transform: capitalize;"><?php echo $not->title; ?></td>
                                                    <td style="font-weight: bolder; text-transform: capitalize;"><?php echo $not->supplier; ?></td>
                                                    <td style="font-weight: bolder;"><?php echo $not->notice; ?></td>
                                                    <td style="font-weight: bolder;"><?php echo $date_format->getDate($not->created_at) ?></td>
                                                    <td><a href="notice_detail.php?id=<?php echo $not->id; ?>">View Details</a></td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <tr>
                                                    <td style="text-transform: capitalize;"><?php echo $not->title; ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $not->supplier; ?></td>
                                                    <td><?php echo $not->notice; ?></td>
                                                    <td><?php echo $date_format->getDate($not->created_at) ?></td>
                                                    <td><a href="notice_detail.php?id=<?php echo $not->id; ?>">View Details</a></td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="new_notice.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="new_notice.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
