<?php
require_once '../../Core/init.php';

if(empty($_SESSION['gen_user'])) {
    header('location: ../../index.php');
}

if (empty($_GET['id'])) {
    header('attendance_reports.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$report = $fetch_data->getSingleItem('SELECT *', 'Employee_Report', 'id', $_GET['id']);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Employee - Report</title>

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

                <?php include '../../Warehouse/includes/alert.php'; ?>
            
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Report</h4>
                                <p class="category">Any notice to leave behind for other workers</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="../../Submits/edit_report.php">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Report</label>
                                                <textarea rows="5" class="form-control" name="content" placeholder="" required><?php echo $report->content; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Submit Report</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- footer -->
        <?php include '../../Warehouse/includes/footer.php'; ?>

    </div>
</div>


</body>

    <!-- scripts -->
    <?php include '../../Warehouse/includes/scripts.php'; ?>

</html>
