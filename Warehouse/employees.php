<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->paginationTotal('User');
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

$all_employees = $fetch_data->getItemsWithLimitOffset("SELECT User.id, first_name, status, last_name, other_name, User_Group.name AS group_name, Account_Status.name AS status_name", "User", "JOIN User_Group ON User_Group.id = User.user_group JOIN Account_Status ON Account_Status.id = User.status", $rows, $offset);

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

	<title>Admin - Employees</title>

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
                                <h4 class="title">Employees</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                                <p class="pull-right">
                                <form method="GET" action="./find_employees.php">
                                    <div class="input-group">
                                    <input type="text" name="keyword" autocomplete="off" class="form-control input-sm pull-right" style="width: 250px; color:#000;" placeholder="Search by Employee Name, & Group..." required="">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                    </div>
                                </form>
                                </p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Other Name</th>
                                        <th>Group</th>
                                        <th>Account Status</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($all_employees as $employee): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $employee->first_name; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $employee->last_name; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $employee->other_name; ?></td>
                                            <td><?php echo $employee->group_name; ?></td>
                                            <td><?php echo $employee->status_name; ?></td>
                                            <td>
                                                <?php
                                                    if ($employee->status == 1) {
                                                        //status is active
                                                        ?>
                                                        <a href="../Submits/verification.php?employee_deactivate=<?php echo $employee->id; ?>" style="color: red;">Deactivate</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="../Submits/verification.php?employee_activate=<?php echo $employee->id; ?>" style="color: green;">Activate</a>
                                                        <?php
                                                    }
                                                ?>
                                                 | <a href="edit_user.php?id=<?php echo $employee->id; ?>">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="employees.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="employees.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
