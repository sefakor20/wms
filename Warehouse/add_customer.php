<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$a_status = $fetch_data->fetchData('SELECT * FROM Account_Status');
$company_groups = $fetch_data->fetchData('SELECT * FROM Company_Group');

//alert for remaining items
include 'includes/danger_alert.php';

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Add Company</title>

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
                                <h4 class="title">Add Company</h4>
                                <p class="category">Clients you will transact business with</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/add_customer.php">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control" name="name" placeholder ="Nana and son's chemical shop" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Group</label>
                                                <select class="form-control" name="user_group" required>
                                                    <option value="">- choose group -</option>
                                                    <?php foreach($company_groups as $group): ?>
                                                        <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" placeholder ="Username" name="username" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tel</label>
                                                <input type="tel" class="form-control" placeholder="0202000888" name="tel" required>
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

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Add Company</button>
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
