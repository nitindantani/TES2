<?php
// Assuming you already have the variables for place prices (children and adults)
$adult_price = 100;  // Example price per adult
$child_price = 50;   // Example price per child

// Get the number of children and adults selected
$children = $_POST['children'] ?? 0;
$adults = $_POST['adults'] ?? 1;

// Calculate total price
$total_price = ($children * $child_price) + ($adults * $adult_price);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Styles from previous code */
        /* Add your styles here */
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirm Payment</h2>
        <form method="post" action="payment_success.php">
            <div class="input-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="UPI">UPI</option>
                    <option value="Card">Card Payment</option>
                    <option value="Cash">Cash on Spot</option>
                </select>
            </div>

            <div class="input-group">
                <label>Total Price: ₹<?php echo $total_price; ?></label>
            </div>

            <!-- Show QR code only for UPI and Card -->
            <div id="qr-code" class="qr-code" style="display: none;">
                <p><strong>Scan the QR Code to Pay:</strong></p>
                <img src="https://www.qr-code-generator.com/wp-content/themes/qr/new_structure/assets/media/images/qr-code-lg.svg" alt="QR Code" />
            </div>

            <!-- Hidden inputs to pass selected values -->
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <input type="hidden" name="adults" value="<?php echo $adults; ?>">
            <input type="hidden" name="children" value="<?php echo $children; ?>">

            <button type="submit" class="pay-btn">Pay Now</button>
        </form>
    </div>

    <script>
        // Show QR code only if UPI or Card is selected
        document.getElementById('payment_method').addEventListener('change', function() {
            const qrCodeDiv = document.getElementById('qr-code');
            if (this.value === 'UPI' || this.value === 'Card') {
                qrCodeDiv.style.display = 'block';  // Show QR code
            } else {
                qrCodeDiv.style.display = 'none';   // Hide QR code
            }
        });
    </script>
</body>
</html>
