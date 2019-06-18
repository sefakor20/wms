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
$search_for_customers = $fetch_data->search("SELECT Company.id, Company.name AS company_name, Company_Group.name AS company_group, tel, status FROM company JOIN Company_Group ON Company_Group.id = Company.user_group WHERE Company_group.name LIKE '%$item%' OR Company.name LIKE '%$item%' ORDER BY Company.id DESC", $item);

?>
<!doctype html>
<html lang="en">
<head>
	
    <?php include 'includes/fav_icon.php'; ?>

	<title>Admin - Companies</title>

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
                    <div class="col-md-10">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Search Result</h4>
                                <p class="category">You've searched for: <?php echo $_GET['keyword']; ?> </p>
                                <p class="text-right"><a href="./customers.php" class="btn btn-primary"><i class="fa fa-reply"></i> Go back</a></p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Company Name</th>
                                        <th>Group</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($search_for_customers as $result): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $result->company_name; ?></td>
                                            <td><?php echo $result->company_group; ?></td>
                                            <td>
                                                 <a href="edit_company.php?id=<?php echo $result->id; ?>"><i class="fa fa-eye"></i>View details</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($search_for_customers)) { ?>
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
