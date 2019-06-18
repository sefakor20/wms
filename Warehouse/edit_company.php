<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

if (empty($_GET['id'])) {
    header('location: customers.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$a_status = $fetch_data->fetchData('SELECT * FROM Account_Status');
$company_groups = $fetch_data->fetchData('SELECT * FROM Company_Group');
$selected_company = $fetch_data->getSingleJoinItem("SELECT Company.name, username, tel, Company_Group.name AS c_group, user_group, Account_Status.name AS a_status, status", 'Company', "JOIN Company_Group ON Company_Group.id = Company.user_group JOIN Account_Status ON Account_Status.id = Company.status", "Company.id", $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Edit Company</title>

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
                                <h4 class="title">Edit Company</h4>
                                <p class="category">Updating selected company details</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/admin_edit_company.php">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo $selected_company->name; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Group</label>
                                                <select class="form-control" name="user_group" required>
                                                    <option value="<?php echo $selected_company->user_group; ?>"><?php echo $selected_company->c_group; ?></option>
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
                                                    <option value="<?php echo $selected_company->status; ?>"><?php echo $selected_company->a_status; ?></option>
                                                    <?php foreach($a_status as $status): ?>
                                                        <option value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" value="<?php echo $selected_company->username; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tel</label>
                                                <input type="tel" class="form-control" value="<?php echo $selected_company->tel; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Update Company</button>
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
