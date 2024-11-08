<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$url = $_SERVER['REQUEST_URI'];
if (!strpos($url, 'msg')){
    $cart_id = $_GET['number'];
    include_once __DIR__.'/partials/header.php';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Payment Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 1.8rem;
            color: #333;
            text-align: center;
            margin-bottom: 1rem;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .back-link {
            color: #0066cc;
            text-decoration: none;
            font-size: 0.9rem;
        }

        /* Payment Summary */
        .summary {
            border-bottom: 1px solid #ddd;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .summary h2 {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .summary p {
            font-size: 1rem;
            color: #555;
        }

        /* Choose Cryptocurrency */
        .crypto-options {
            display: flex;
            justify-content: space-around;
            margin-bottom: 1.5rem;
        }

        .crypto-option {
            padding: 0.5rem 1rem;
            border: 2px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
        }

        .crypto-option.selected {
            border-color: #0066cc;
            background-color: #e6f0ff;
        }

        /* Payment Instructions */
        .instructions {
            border-top: 1px solid #ddd;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        .instructions h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .instructions p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        /* Wallet Address and QR Code */
        .wallet {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f4f4f9;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .wallet input {
            border: none;
            background: transparent;
            color: #333;
            width: 100%;
            margin-right: 10px;
            font-size: 0.9rem;
        }

        .wallet button {
            background: #0066cc;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Timer and Status */
        .status {
            text-align: center;
            margin-top: 1rem;
        }

        .timer {
            font-size: 1.2rem;
            color: #ff3333;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.8rem;
            color: #777;
        }

        .footer a {
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo"><img style="max-width: 120px;" src="https://dexcartgo.online/image/images/67082743707ae.webp?p=logo" alt=""></div>
        <a href="/" class="back-link">Back to Homepage</a>
    </div>

    <!-- Page Title -->
    <h1>Complete Payment</h1>
    <?php if (!strpos($url, 'msg')) { ?>
    <!-- Payment Summary -->
    <div class="summary">
        <h2>Order Summary</h2>
        <p>Item: <?=$item_name?></p>
        <p>Total Amount: <strong>$<?=$item_price?> USD</strong></p>
        <p>Total Quality: <strong><?=$item_quantity?></strong></p>
        <p>Transaction ID: <strong>#<?=generateRandomNumericCode(6) ?></strong></p>
    </div>

    <!-- Choose Cryptocurrency -->
    <div class="crypto-options">
        <div class="crypto-option" onclick="selectCrypto('btc')">
            Bitcoin (BTC)
        </div>
        <div class="crypto-option" onclick="selectCrypto('eth')">
            Ethereum (ETH)
        </div>
        <div class="crypto-option" onclick="selectCrypto('usdt')">
            Tether (USDT)
        </div>
    </div>

    <!-- Payment Instructions -->
    <div class="instructions">
        <h3>Payment Instructions</h3>
        <p>Send the exact amount to the wallet address shown below. Your order will be processed once the payment is confirmed.</p>

        <!-- Wallet Address and QR Code -->
        <div class="wallet">
            <input type="text" id="walletAddress" value="Wallet address will appear here" readonly>
            <button onclick="copyAddress()">Copy</button>
        </div>

        <p>Amount to Send: <strong id="amount">$<?=$item_price?> USD</strong></p>
<!--        <p>Time Remaining: <span class="timer" id="timer">15:00</span></p>-->
    </div>

    <!-- Transaction Status -->
    <div class="status">
        <p>Status: <span id="statusMessage">Awaiting Payment</span></p>
    </div>
    <?php } ?>
    <script>
        // Function to display alerts based on URL message parameter
        function showAlert(message, type = 'info') {
            const alertBox = document.createElement('div');
            alertBox.className = `alert alert-${type} alert-dismissible fade show`;
            alertBox.role = 'alert';
            alertBox.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
            document.body.prepend(alertBox);

            // Automatically remove the alert after 5 seconds
            setTimeout(() => alertBox.remove(), 5000);
        }

        // Check URL parameters for 'msg' and display corresponding alert
        const urlParams = new URLSearchParams(window.location.search);
        const msg = urlParams.get('msg');

        if (msg) {
            switch (msg) {
                case 'payment_details_recorded_successfully':
                    showAlert('Payment details have been recorded successfully!', 'success');
                    break;
                case 'error_recording_payment_details':
                    showAlert('An error occurred while recording payment details. Please try again.', 'danger');
                    break;
                case 'shop_details_not_found':
                    showAlert('Shop details could not be found. Please contact support.', 'warning');
                    break;
                case 'inventory_details_not_found':
                    showAlert('Inventory details could not be found. Please contact support.', 'warning');
                    break;
                case 'cart_details_not_found':
                    showAlert('Cart details could not be found. Please check your cart ID.', 'warning');
                    break;
                case 'cart_id_not_provided':
                    showAlert('Cart ID was not provided. Please check and try again.', 'warning');
                    break;
                default:
                    showAlert('An unexpected error occurred. Please try again.', 'danger');
                    break;
            }
        }
    </script>
    <?php if (!strpos($url, 'msg')) { ?>
    <div class="text-muted text-center mb-2">Click the button below if you have completed your payment</div>
    <div class="d-flex justify-content-center">
        <!-- Form to send data to insert.php on button click -->
        <form action="insert.php" method="POST">
            <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
            <button type="submit" class="btn btn-outline-primary px-3 py-2">Payment Completed</button>
        </form>
    </div>



    <!-- Footer -->
    <div class="footer">
        <p>Crypto payments are non-reversible. <a href="#">Terms & Conditions</a> | <a href="#">Privacy Policy</a></p>
    </div>
</div>

<script>
    function selectCrypto(crypto) {
        document.querySelectorAll('.crypto-option').forEach(option => option.classList.remove('selected'));
        document.querySelector(`.crypto-option[onclick="selectCrypto('${crypto}')"]`).classList.add('selected');

        // Define wallet addresses and exchange rates
        const walletAddresses = {
            btc: '<?=$btc_address?>',
            eth: '<?=$eth_address?>',
            usdt: '<?=$usdt_address?>'
        };

        const exchangeRates = {
            btc: 76154.31,  // USD rate per BTC
            eth: 2913.32,   // USD rate per ETH
            usdt: 1         // USD rate per USDT
        };

        // Set the wallet address
        document.getElementById('walletAddress').value = walletAddresses[crypto];

        <?php
            $total_item_price = $item_price * $item_quantity
        ?>
        // Calculate and set the crypto amount needed for 200 USD
        const amount = <?=$total_item_price?> / exchangeRates[crypto];
        document.getElementById('amount').textContent = `${amount.toFixed(6)} ${crypto.toUpperCase()}`;
    }

    function copyAddress() {
        const walletAddress = document.getElementById("walletAddress");
        walletAddress.select();
        document.execCommand("copy");
        alert("Wallet address copied to clipboard!");
    }
</script>


<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
