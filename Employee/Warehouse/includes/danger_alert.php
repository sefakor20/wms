<?php
$danger_total = $fetch_data->dangerTotal('Warehouse_Stock', 500);
$danger_items = $fetch_data->dangerItems("SELECT Warehouse_Stock.id, Item.name AS item_name, Category.name AS category_name, quantity", 'Warehouse_Stock', "JOIN Item ON Item.id = Warehouse_Stock.item_id JOIN Category ON Category.id = Warehouse_Stock.category_id", 'quantity', 500);