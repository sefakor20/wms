<?php
require_once dirname(__DIR__).'/Core/init.php';
if(empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

//alert for remaining items
include 'includes/danger_alert.php';

$pagination = $fetch_data->paginationTotal('Company');
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

$all_companies = $fetch_data->getItemsWithLimitOffset("SELECT Company.id, Company.name AS company_name, Company_Group.name AS company_group, tel, status", "Company", "JOIN Company_Group ON Company_Group.id = Company.user_group", $rows, $offset);

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Companies</h4>
                                <p class="category">Showing Page: <?php echo $page; ?> 0f <?php echo $pages; ?> (Total entries: <?php echo $total; ?>)</p>
                                <p class="pull-right">
                                <form method="GET" action="./find_customers.php">
                                    <div class="input-group">
                                    <input type="text" name="keyword" autocomplete="off" class="form-control input-sm pull-right" style="width: 250px; color:#000;" placeholder="Search by Company Name, & Group..." required="">
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
                                        <th>Company Name</th>
                                        <th>Group</th>
                                        <th>Tel</th>
                                        <th>Activities</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($all_companies as $company): ?>
                                        <tr>
                                            <td style="text-transform: capitalize;"><?php echo $company->company_name; ?></td>
                                            <td><?php echo $company->company_group; ?></td>
                                            <td><?php echo $company->tel; ?></td>
                                            <td>
                                                <?php
                                                    if ($company->status == 1) {
                                                        //status is active
                                                        ?>
                                                        <a href="../Submits/verification.php?company_deactivate=<?php echo $company->id; ?>" style="color: red;">Deactivate</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="../Submits/verification.php?company_activate=<?php echo $company->id; ?>" style="color: green;">Activate</a>
                                                        <?php
                                                    }
                                                ?>
                                                 | <a href="edit_company.php?id=<?php echo $company->id; ?>">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <?php if(($page - 1) >= 1): ?>
                                      <li><a href="customers.php?page=<?php echo $prevPage; ?>">&laquo; Prev</a></li>
                                    <?php endif; ?>
                                    <?php if(($page + 1) <= $pages): ?>
                                      <li><a href="customers.php?page=<?php echo $nextPage; ?>">Next &raquo;</a></li>
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
