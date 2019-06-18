<?php
require_once dirname(__DIR__) . '/Core/init.php';

if (empty($_SESSION['admin'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$a_status = $fetch_data->fetchData('SELECT * FROM Account_Status');
$company_groups = $fetch_data->fetchData('SELECT * FROM Company_Group');

if (isset($_POST['submit'])) {
    $from =  date('Y-m-d', strtotime($_POST['from']));
    $to = date('Y-m-d', strtotime($_POST['to']));
    $item = $_POST['item'];

    switch ($item) {
        case '1':
            //generate incoming items Reports 
            $generate_incoming_items_report = $fetch_data->generateReports("SELECT Item.name AS item_name, Category.name AS category_name, quantity, CONCAT(User.first_name, ' ', User.last_name, ' ', User.other_name) AS personnel, expiry_date, Company.name AS supplier, Warehouse_All_Stock.created_at FROM Warehouse_All_Stock JOIN Item ON Item.id = Warehouse_All_Stock.item_id JOIN Category ON Category.id = Warehouse_All_Stock.category_id JOIN User ON User.id = Warehouse_All_Stock.personnel_id JOIN Company ON Company.id = Warehouse_All_Stock.supplier_id WHERE Warehouse_All_Stock.created_at BETWEEN '$from' AND '$to'");
            break;

        case '2':
            //generate outgoing items reports
            $generate_out_going_items = $fetch_data->generateReports("SELECT Item.name AS item_name, Category.name AS category_name, released_quantity, CONCAT(User.first_name, ' ', User.last_name, ' ', User.other_name) AS personnel, Warehouse_Release_Stock.status, Company.name AS client, Warehouse_Release_Stock.created_at FROM Warehouse_Release_Stock JOIN Item ON Item.id = Warehouse_Release_Stock.item_id JOIN Category ON Category.id = Warehouse_Release_Stock.category_id JOIN User ON User.id = Warehouse_Release_Stock.personnel_id JOIN Company ON Company.id = Warehouse_Release_Stock.client_id WHERE Warehouse_Release_Stock.created_at BETWEEN '$from' AND '$to'");
            break;

        default:
            $_SESSION['default_report'] = 'No Item was selected';
            break;
    }
}


//alert for remaining items
include 'includes/danger_alert.php';

?>
<!doctype html>
<html lang="en">

<head>

    <?php include 'includes/fav_icon.php'; ?>

    <title>Admin - Generate Report</title>

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
                        <div class="col-md-10">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Report</h4>
                                    <p class="category">Generate report based on date & Item</p>
                                </div>
                                <div class="content">
                                    <form method="POST" action="gen_report.php">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="item">Item</label>
                                                    <select class="form-control" name="item">
                                                        <option class="selected">-Choose Item-</option>
                                                        <option value="1">Incoming Items</option>
                                                        <option value="2">Outgoing Items</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>From</label>
                                                    <input type="date" class="form-control" placeholder="Choose date" name="from" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>To</label>
                                                    <input type="date" class="form-control" placeholder="Choose date" name="to" required>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" onclick="myFunction()" class="btn btn-info btn-fill pull-right" name="submit">Generate</button>
                                        <div class="clearfix"></div>
                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row" id="reports" style="visibility: hidden;">
                        <div class="col-md-10">
                            <div class="card">
                                <?php if (isset($generate_incoming_items_report)) { ?>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" class="text-center" style="font-size:20px; font-weight:bold; color:black;">Incoming Items</th>
                                                </tr>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Category</th>
                                                    <th>Quantity</th>
                                                    <th>Personnel</th>
                                                    <th>Supplier</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($generate_incoming_items_report as $result) :  ?>
                                                    <tr>
                                                        <td><?php echo $result->item_name; ?></td>
                                                        <td><?php echo $result->category_name; ?></td>
                                                        <td><?php echo $result->quantity; ?></td>
                                                        <td><?php echo $result->personnel; ?></td>
                                                        <td><?php echo $result->supplier; ?></td>
                                                        <td><?php echo $result->created_at; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($generate_incoming_items_report)) { ?>
                                                    <tr>
                                                        <td colspan="6">
                                                            <h3 class="text-danger text-center">No Result Found!</h3>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <!-- <br>
                                                                <div class="text-right">
                                                                    <form method="post" action="../Submits/export_incoming_items.php">
                                                                        <input type="submit" value="CSV Export" class="btn btn-fill btn-info" name="submit">
                                                                    </form>
                                                                </div>
                                                                <br><br><br> -->
                                    </div>
                                <?php } ?>

                                <?php if (isset($generate_out_going_items)) { ?>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" class="text-center" style="font-size:20px; font-weight:bold; color:black;">Outgoing Items</th>
                                                </tr>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Category</th>
                                                    <th>Quantity</th>
                                                    <th>Personnel</th>
                                                    <th>Supplier</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($generate_out_going_items as $result) :  ?>
                                                    <tr>
                                                        <td><?php echo $result->item_name; ?></td>
                                                        <td><?php echo $result->category_name; ?></td>
                                                        <td><?php echo $result->released_quantity; ?></td>
                                                        <td><?php echo $result->personnel; ?></td>
                                                        <td><?php echo $result->client; ?></td>
                                                        <td><?php echo $result->created_at; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!-- <br>
                                                                <div class="pull-right">
                                                                    <a href="#" class="btn btn-danger btn-fill"><i class="fa fa-print"></i> Export to CSV</a>
                                                                </div> -->
                                    </div>
                                <?php } ?>

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
<script>
    // $("#toggleReport").click(function() {
    //     $("#reports").toggle();
    // });

    function myFunction() {
        document.getElementById("reports").style.visibility = "visible";
    }
</script>

</html>