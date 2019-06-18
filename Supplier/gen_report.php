<?php
require_once dirname(__DIR__) . '/Core/init.php';

if (empty($_SESSION['sup_id'])) {
    header('location: ../index.php');
}

$fetch_data = new Fetch($connection);

$a_status = $fetch_data->fetchData('SELECT * FROM Account_Status');
$company_groups = $fetch_data->fetchData('SELECT * FROM Company_Group');

if (isset($_POST['submit'])) {
    $from =  date('Y-m-d', strtotime($_POST['from']));
    $to = date('Y-m-d', strtotime($_POST['to']));

    $generate_report = $fetch_data->exportItemsToCsvFormat("SELECT Warehouse_Stock_Request.id, request_status, Item.name AS item, Category.name AS category, quantity, Request_Status.name AS r_status, Warehouse_Stock_Request.created_at FROM Warehouse_Stock_Request JOIN Item ON Item.id = Warehouse_Stock_Request.item_id JOIN Category ON Category.id = Warehouse_Stock_Request.category_id JOIN Request_Status ON Request_Status.id = Warehouse_Stock_Request.request_status WHERE Warehouse_Stock_Request.created_at BETWEEN $from AND $to");
}


//alert for remaining items
include 'includes/danger_alert.php';

?>
<!doctype html>
<html lang="en">

<head>

    <?php include '../Warehouse/includes/fav_icon.php'; ?>

    <title>Supplier - Generate Report</title>

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
                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="item">Item</label>
                                                    <select class="form-control" name="item">
                                                        <option class="selected">-Choose Item-</option>
                                                        <option value="1">Incoming Items</option>
                                                        <option value="2">Outgoing Items</option>
                                                    </select>
                                                </div>
                                            </div> -->
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
                                    </div>
                                <?php } ?>

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

<script>
    function myFunction() {
        document.getElementById("reports").style.visibility = "visible";
    }
</script>

</html>