<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PostgreSQL connection
$host     = 'dpg-d0g4sbjuibrs73f8ot10-a.oregon-postgres.render.com';
$port     = '5432';
$dbname   = 'touristbooking';
$user     = 'touristbooking_user';
$password = 'QbFGlPz2ytIxmfJdHSkaeO3BCSu7HBMl';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mobile     = trim($_POST['mobile'] ?? '');
    $visit_date = trim($_POST['visit_date'] ?? '');

    if (empty($mobile) || empty($visit_date)) {
        $error = "❌ Both mobile number and visit date are required.";
    } elseif (!preg_match('/^\d{10}$/', $mobile)) {
        $error = "❌ Mobile must be 10 digits.";
    }

    if (empty($error)) {
        // 1. Find booking
        $query1 = "SELECT id, name FROM bookings WHERE mobile = $1 AND visit_date = $2";
        $result1 = pg_query_params($conn, $query1, [$mobile, $visit_date]);

        if (!$result1 || pg_num_rows($result1) === 0) {
            $error = "❌ No booking found for that mobile & date.";
        } else {
            $booking = pg_fetch_assoc($result1);
            $booking_id = $booking['id'];

            // 2. Find PDF
            $query2 = "SELECT pdf_data FROM booking_pdfs WHERE booking_id = $1";
            $result2 = pg_query_params($conn, $query2, [$booking_id]);

            if (!$result2 || pg_num_rows($result2) === 0) {
                $error = "❌ Ticket PDF not found for booking #$booking_id.";
            } else {
                $row = pg_fetch_assoc($result2);
                $pdf_data = $row['pdf_data'];

                // 3. Send PDF
                header('Content-Type: application/pdf');
                header("Content-Disposition: attachment; filename=ticket_{$booking_id}.pdf");
                echo pg_unescape_bytea($pdf_data);
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find My Ticket</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            padding: 30px;
            background: #f2f2f2;
        }
        form {
            background: white;
            max-width: 400px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <form method="POST" novalidate>
        <h2>Find Your Booking Ticket</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <input 
            type="text" 
            name="mobile" 
            placeholder="Enter your mobile number" 
            required 
            pattern="\d{10}"
            value="<?= isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '' ?>"
        >
        <input 
            type="date" 
            name="visit_date" 
            required
            value="<?= isset($_POST['visit_date']) ? htmlspecialchars($_POST['visit_date']) : '' ?>"
        >
        <button type="submit">Download My Ticket</button>
    </form>
</body>
</html>
