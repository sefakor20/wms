<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: employees.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$a_status = $fetch_data->fetchData('SELECT * FROM Account_Status');
$user_groups = $fetch_data->fetchData('SELECT * FROM User_Group');
$selected_user = $fetch_data->getSingleJoinItem("SELECT first_name, last_name, other_name, user_group, status, User_Group.name AS u_group, Account_Status.name AS a_status, username", 'User', "JOIN User_Group ON User_Group.id = User.user_group JOIN Account_Status ON Account_Status.id = User.status", "User.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Edit Employee</title>

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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Employee</h4>
                                <p class="category">Details of selected employee</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/edit_user.php">
                                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                    <input type="hidden" name="admin_id" value="<?php echo $_SESSION['admin']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" disabled value ="<?php echo $selected_user->first_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" disabled value ="<?php echo $selected_user->last_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Other Name</label>
                                                <input type="text" class="form-control" disabled value ="<?php echo $selected_user->other_name; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Group</label>
                                                <select class="form-control" name="user_group" required>
                                                    <option value="<?php echo $selected_user->user_group; ?>"><?php echo $selected_user->u_group; ?></option>
                                                        <?php foreach($user_groups as $group): ?>
                                                            <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Status</label>
                                                <select class="form-control" name="account_status" required>
                                                    <option value="<?php echo $selected_user->status; ?>"><?php echo $selected_user->a_status; ?></option>
                                                    <?php foreach($a_status as $status): ?>
                                                        <option value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Administrator Password</label>
                                                <input type="password" class="form-control" placeholder="Enter Password" name="admin_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Username</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $selected_user->username; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Edit Employee</button>
                                    <div class="clearfix"></div>
                                </form>
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
