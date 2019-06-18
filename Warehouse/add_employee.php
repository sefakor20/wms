<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$a_status = $fetch_data->fetchData('SELECT * FROM Account_Status');
$user_groups = $fetch_data->fetchData('SELECT * FROM User_Group');

//alert for remaining items
include 'includes/danger_alert.php';

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Add Employee</title>

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
                                <h4 class="title">Add Employee</h4>
                                <p class="category">Dedicate certain administrative actions to other employees</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/add_employee.php">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name" placeholder ="John" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name" required placeholder ="Doe">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Other Name</label>
                                                <input type="text" class="form-control" name="other_name" placeholder ="kofi">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Group</label>
                                                <select class="form-control" name="user_group" required>
                                                    <option value="">- choose group -</option>
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
                                                    <option value="">- choose account status -</option>
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
                                                <label for="exampleInputEmail1">Username</label>
                                                <input type="text" class="form-control" placeholder ="Username" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Choose Password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="Retype Password" name="confirm_password" required>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Add Employee</button>
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
