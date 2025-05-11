<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to DBs
$booking_conn = new mysqli("sql206.infinityfree.com", "if0_38952666", "Nitin3001n", "if0_38952666_touristbooking");
$pdf_conn     = new mysqli("sql206.infinityfree.com", "if0_38952666", "Nitin3001n", "if0_38952666_touristpdf");

if ($booking_conn->connect_error) {
    die("Booking DB connection failed: " . $booking_conn->connect_error);
}
if ($pdf_conn->connect_error) {
    die("PDF DB connection failed: " . $pdf_conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1) Grab & sanitize
    $mobile     = trim($_POST['mobile']      ?? '');
    $visit_date = trim($_POST['visit_date'] ?? '');

    // 2) Validate
    if (empty($mobile) || empty($visit_date)) {
        $error = "❌ Both mobile number and visit date are required.";
    } elseif (!preg_match('/^\d{10}$/', $mobile)) {
        $error = "❌ Mobile must be 10 digits.";
    }

    // 3) Query bookings
    if (empty($error)) {
        $stmt = $booking_conn->prepare(
            "SELECT id, name 
             FROM bookings 
             WHERE mobile = ? 
               AND visit_date = ?"
        );
        if (!$stmt) {
            die("Prepare failed: " . $booking_conn->error);
        }
        $stmt->bind_param("ss", $mobile, $visit_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = "❌ No booking found for that mobile & date.";
        } else {
            $booking    = $result->fetch_assoc();
            $booking_id = $booking['id'];
            $stmt->close();

            // 4) Query PDF
            $stmt_pdf = $pdf_conn->prepare(
                "SELECT pdf_data 
                 FROM booking_pdfs 
                 WHERE booking_id = ?"
            );
            if (!$stmt_pdf) {
                die("Prepare failed: " . $pdf_conn->error);
            }
            $stmt_pdf->bind_param("i", $booking_id);
            $stmt_pdf->execute();
            $stmt_pdf->store_result();

            if ($stmt_pdf->num_rows === 0) {
                $error = "❌ Ticket PDF not found for booking #$booking_id.";
            } else {
                $stmt_pdf->bind_result($pdf_data);
                $stmt_pdf->fetch();

                // 5) Send PDF
                header('Content-Type: application/pdf');
                header("Content-Disposition: attachment; filename=ticket_{$booking_id}.pdf");
                echo $pdf_data;
                exit();
            }
            $stmt_pdf->close();
        }
    }
}

$booking_conn->close();
$pdf_conn->close();
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
