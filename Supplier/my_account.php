<?php
require_once dirname(__DIR__).'/Core/init.php';

if(empty($_SESSION['sup_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$user = $fetch_data->getSingleItem("SELECT name, username, tel", 'Company', 'id', $_SESSION['sup_id']);

?>
<!doctype html>
<html lang="en">
<head>
    
    <?php include '../Warehouse/includes/fav_icon.php'; ?>

    <title>Supplier - My Account</title>

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

                <?php include '../Warehouse/includes/alert.php'; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">My Account</h4>
                                <p class="category">Update my account</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../Submits/supplier_update_account.php">
                                    <input type="hidden" name="id" value="<?php echo $_SESSION['sup_id']; ?>" required>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $user->name; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Username</label>
                                                <input type="text" class="form-control" value ="<?php echo $user->username; ?>" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tel</label>
                                                <input type="tel" class="form-control" value="<?php echo $user->tel; ?>" name="tel" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" class="form-control" placeholder="Enter Old Password" name="old_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control" placeholder="Choose New Password" name="new_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="Retype Password" name="confirm_password" required>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Update My Account</button>
                                    <div class="clearfix"></div>
                                </form>
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
