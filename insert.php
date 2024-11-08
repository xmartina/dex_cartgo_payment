<?php
include_once __DIR__.'/../include/config.php';

// Get the cart_id from the POST data
$cart_id = $_POST['cart_id'] ?? null;
if (!$cart_id) {
    echo "Cart ID not provided.";
    exit;
}

// Retrieve cart details
$sql = "SELECT * FROM cart_items WHERE cart_id = $cart_id";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $item_name = $row['item_description'];
    $item_price = $row['unit_price'];
    $item_quantity = $row['quantity'];
    $item_created_at = $row['created_at'];
    $transaction_id = generateRandomNumericCode(7);  // Generate a transaction ID

    // Retrieve inventory and shop details
    $inventory_id = $row['inventory_id'];
    $inventory_sql = "SELECT * FROM inventories WHERE id = $inventory_id";
    $inventory_result = $conn->query($inventory_sql);

    if ($inventory_result && $inventory_row = $inventory_result->fetch_assoc()) {
        $inventory_shop_id = $inventory_row['shop_id'];
        $shop_sql = "SELECT * FROM shops WHERE id = $inventory_shop_id";
        $shop_result = $conn->query($shop_sql);

        if ($shop_result && $shop_row = $shop_result->fetch_assoc()) {
            $shop_owner_name = $shop_row['name'];
            $shop_legal_name = $shop_row['legal_name'];

            // Insert details into the payment_records table
            $insert_sql = "INSERT INTO z_crypto_manual_payment (item_name, item_price, item_quantity, item_created_at, transaction_id, shop_owner_name, shop_legal_name)
                           VALUES ('$item_name', '$item_price', '$item_quantity', '$item_created_at', '$transaction_id', '$shop_owner_name', '$shop_legal_name')";

            if ($conn->query($insert_sql) === TRUE) {
                echo "Payment details recorded successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Shop details not found.";
        }
    } else {
        echo "Inventory details not found.";
    }
} else {
    echo "Cart details not found.";
}

// Function to generate a random numeric code
function generateRandomNumericCode($length = 7) {
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= rand(0, 9);
    }
    return $randomCode;
}
?>
