<?php
require_once '../../Core/init.php';

if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->paginationTotal('Employee_Report');
$total = $pagination;

$page = (int)$_GET['page'];
$rows = 5000;

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

    <title>Reports</title>

    <?php include 'includes/links.php'; ?>

</head>
<body onload="window.print();" style="background: #E0E0E0;">

<div class="wrapper">
    

        <div class="content">
            <div class="container-fluid">
                <br><br>    
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="card">
                            <div class="header">
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-bordered">
                                    <thead class="text-black">
                                        <th>Content</th>
                                        <th>Employee</th>
                                        <th>Date/Time</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($reports as $rep): ?>
                                            <tr>
                                                <td><?php echo $rep->content; ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $rep->employee; ?></td>
                                                <td><?php echo $date_format->getDate($rep->created_at) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


</div>


</body>

    <!-- scripts -->
    <?php include '../../Warehouse/includes/scripts.php'; ?>

</html>
