<?php
require_once dirname(__DIR__) . '/Core/init.php';
if (empty($_SESSION['client_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);
$date_format = new DateFormat($connection);


$item = $_GET['keyword'];

//search for customers
$search_for_stocks = $fetch_data->search("SELECT Item.name AS item_name, Category.name AS category_name, quantity, Warehouse_All_Release_Stock.created_at FROM Warehouse_All_Release_Stock JOIN Item ON Item.id = Warehouse_All_Release_Stock.item_id JOIN Category ON Category.id = Warehouse_All_Release_Stock.category_id WHERE Item.name LIKE '%$item%' OR Category.name LIKE '%$item%' OR Warehouse_All_Release_Stock.created_at LIKE '%$item%' ORDER BY Warehouse_All_Release_Stock.id ASC", $item);

?>
<!doctype html>
<html lang="en">

<head>

    <?php include '../Warehouse/includes/fav_icon.php'; ?>

    <title>Client - Search Result</title>

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
                    <div class="row">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Search Result</h4>
                                    <p class="category">You've searched for: <?php echo $_GET['keyword']; ?> </p>
                                    <p class="text-right"><a href="./all_stock.php" class="btn btn-primary"><i class="fa fa-reply"></i> Go back</a></p>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover">
                                        <thead>
                                            <th>Item</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Date/Time</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($search_for_stocks as $result) : ?>
                                                <tr>
                                                    <td><?php echo $result->item_name; ?></td>
                                                    <td><?php echo $result->category_name; ?></td>
                                                    <td><?php echo $result->quantity; ?></td>
                                                    <td><?php echo $date_format->getDate($stock->created_at) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($search_for_stocks)) { ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <h2 class="text-center text-danger">No result found!</h2>
                                                    </td>
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
            <?php include '../Warehouse/includes/footer.php'; ?>

        </div>
    </div>


</body>

<!-- scripts -->
<?php include '../Warehouse/includes/scripts.php'; ?>

</html>