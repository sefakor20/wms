<?php
//export incoming items
require_once dirname(__DIR__) . '/Core/init.php';

$database = new Database($connection);
$fetch_data = new Fetch($connection);

if (Inputs::submitType()) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Item', 'Category', 'Quantity', 'Personnel', 'Supplier', 'Date'));

    //generate incoming items Reports
    $generate_incoming_items_report = $fetch_data->generateReports("SELECT Item.name AS item_name, Category.name AS category_name, quantity, CONCAT(User.first_name, ' ', User.last_name, ' ', User.other_name) AS personnel, expiry_date, Company.name AS supplier, Warehouse_All_Stock.created_at FROM Warehouse_All_Stock JOIN Item ON Item.id = Warehouse_All_Stock.item_id JOIN Category ON Category.id = Warehouse_All_Stock.category_id JOIN User ON User.id = Warehouse_All_Stock.personnel_id JOIN Company ON Company.id = Warehouse_All_Stock.supplier_id WHERE Warehouse_All_Stock.created_at BETWEEN '$from' AND '$to'");
    fputcsv($output, $generate_incoming_items_report);
    fclose($output);
}
