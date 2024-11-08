<?php
include_once __DIR__.'/../include/config.php';
$btc_address = '3FZbgi29cpjq2GjdwV8eyHuJJnkLtktZc5';
$eth_address = '0x32Be343B94f860124dC4fEe278FDCBD38C102D88';
$usdt_address = '0x731d15b614C13C6A2AB1f5Bf7E52b68A5C3dE53d';

$sql = "SELECT * FROM cart_items WHERE cart_id = $cart_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$item_name = $row['item_description'];
$item_price = $row['unit_price'];
$inventory_id = $row['inventory_id'];
$item_quantity = $row['quantity'];
$item_created_at = $row['created_at'];
function generateRandomNumericCode($length = 6) {
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= rand(0, 9);
    }
    return $randomCode;
}


$sql = "SELECT * FROM inventories WHERE cart_id = $cart_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


