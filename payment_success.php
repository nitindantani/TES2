<?php
// payment_success.php

// Get the payment details from the POST request
$payment_method = $_POST['payment_method'];
$total_price = $_POST['total_price'];
$adults = $_POST['adults'];
$children = $_POST['children'];

// Simulating a successful payment process
if ($payment_method === "UPI" || $payment_method === "Card") {
    // Simulate payment success
    $payment_status = true; // In reality, you would integrate with the actual payment gateway here
} else {
    // Cash on Spot (no external processing needed)
    $payment_status = true; // Simulating success for Cash on Spot
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-message {
            font-size: 18px;
            color: #333;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($payment_status): ?>
            <h2>Payment Successful!</h2>
            <p class="success-message">Thank you for booking with us! Your payment of ₹<?php echo $total_price; ?> has been successfully processed.</p>
            <a href="index.php" class="btn">Go Back to Homepage</a>
        <?php else: ?>
            <h2>Payment Failed</h2>
            <p>There was an issue with your payment. Please try again later.</p>
        <?php endif; ?>
    </div>
</body>
</html>
