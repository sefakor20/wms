<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->paginationTotal('Employee_Report');
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

$reports = $fetch_data->noComparismWithJoin("SELECT Employee_Report.id, content, Employee_Report.created_at, CONCAT(User.first_name, ' ', User.last_name, ' ', User.last_name) AS employee, personnel_id", 'Employee_Report', "JOIN User ON User.id = Employee_Report.personnel_id", $rows, $offset);

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

    <title>Admin - Reports</title>

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Reports</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                                <p class="text-right"><a href="admin_attendance_reports_pdf.php" target="_blank" class="btn btn-sm btn-danger"><i class="pe-7s-print"> Print Report</i></a></p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Content</th>
                                        <th>Employee</th>
                                        <th>Date/Time</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($reports as $rep): ?>
                                            <tr>
                                                <td><?php echo $rep->content; ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $rep->employee; ?></td>
                                                <td><?php echo $date_format->getDate($rep->created_at); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="attendance_reports.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="attendance_reports.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
