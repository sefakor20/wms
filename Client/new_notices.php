<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

$pagination = $fetch_data->getTwoFieldsTotal('Warehouse_Notice', 'client_id', $_SESSION['client_id'], 'notice_status', 2);
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

$notices = $fetch_data->getPaginationRecords("SELECT Warehouse_Notice.id, title, notice_status, Notice_Status.name AS notice, Warehouse_Notice.created_at", 'Warehouse_Notice', "JOIN Notice_Status ON Notice_Status.id = Warehouse_Notice.notice_status", 'client_id', $_SESSION['client_id'], $rows, $offset);

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

	<title>Client - Notices</title>

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
                                <h4 class="title">Notices</h4>
                                <p class="category">All notices from supplier</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Title</th>
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
                                                        <td style="font-weight: bolder;"><?php echo $not->notice; ?></td>
                                                        <td style="font-weight: bolder;"><?php echo $date_format->getDate($not->created_at) ?></td>
                                                        <td><a href="notice_detail.php?id=<?php echo $not->id; ?>">View Details</a></td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="text-transform: capitalize;"><?php echo $not->title; ?></td>
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
                                      <li><a href="new_notices.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="new_notices.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
