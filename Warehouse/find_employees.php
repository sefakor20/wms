<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$item = $_GET['keyword'];

//search for customers
$search_for_employees = $fetch_data->search("SELECT User.id, CONCAT(first_name, ' ',  last_name, ' ', other_name) AS employee_name, User_Group.name AS group_name FROM User JOIN User_Group ON User_Group.id = User.user_group WHERE User.first_name LIKE '%$item%' OR User.last_name LIKE '%$item%' OR User.other_name LIKE '%$item%' OR User_Group.name LIKE '%$item%' ORDER BY User.id DESC", $item);

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
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Search Result</h4>
                                <p class="category">You've searched for: <?php echo $_GET['keyword']; ?> </p>
                                <p class="text-right"><a href="./employees.php" class="btn btn-primary"><i class="fa fa-reply"></i> Go back</a></p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Employee Name</th>
                                        <th>Group</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($search_for_employees as $result): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $result->employee_name; ?></td>
                                            <td><?php echo $result->group_name; ?></td>
                                            <td>
                                                 <a href="edit_user.php?id=<?php echo $result->id; ?>">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($search_for_employees)) { ?>
                                        <tr>
                                            <td colspan="3"><h2 class="text-center text-danger">No result found!</h2></td>
                                        </tr>
                                    <?php } ?> 
                                    </tbody>
                                </table>
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
