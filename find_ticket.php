<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connections
$booking_conn = new mysqli('sql5.freesqldatabase.com','sql5786934','m3wWsIZkxF','sql5786934');
$pdf_conn     = new mysqli('sql5.freesqldatabase.com','sql5786934','m3wWsIZkxF','sql5786934');

if ($booking_conn->connect_error) die("Booking DB error: " . $booking_conn->connect_error);
if ($pdf_conn->connect_error)     die("PDF DB error: " . $pdf_conn->connect_error);

$error = "";
$tickets = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mobile     = trim($_POST['mobile'] ?? '');
    $visit_date = trim($_POST['visit_date'] ?? '');

    if (empty($mobile) || empty($visit_date)) {
        $error = "❌ Both mobile number and visit date are required.";
    } elseif (!preg_match('/^\d{10}$/', $mobile)) {
        $error = "❌ Mobile must be 10 digits.";
    }

    if (empty($error)) {
        $stmt = $booking_conn->prepare("SELECT id, name, place, unique_code FROM bookings WHERE mobile = ? AND visit_date = ?");
        $stmt->bind_param("ss", $mobile, $visit_date);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Check if PDF exists
            $stmt_pdf = $pdf_conn->prepare("SELECT 1 FROM booking_pdfs WHERE booking_id = ?");
            $stmt_pdf->bind_param("i", $row['id']);
            $stmt_pdf->execute();
            $stmt_pdf->store_result();

            if ($stmt_pdf->num_rows > 0) {
                $tickets[] = $row;
            }

            $stmt_pdf->close();
        }

        if (empty($tickets)) {
            $error = "❌ No tickets found for the given mobile number and visit date.";
        }

        $stmt->close();
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
        .ticket-list {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .ticket {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .ticket:last-child {
            border-bottom: none;
        }
        .ticket code {
            background: #eee;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .download-btn {
            display: inline-block;
            margin-top: 8px;
            background: #28a745;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .download-btn:hover {
            background: #218838;
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
        <button type="submit">Show My Tickets</button>
    </form>

    <?php if (!empty($tickets)): ?>
        <div class="ticket-list">
            <h3>Your Booking Tickets:</h3>
            <?php foreach ($tickets as $t): ?>
                <div class="ticket">
                    <strong><?= htmlspecialchars($t['name']) ?></strong><br>
                    Place: <?= htmlspecialchars($t['place']) ?><br>
                    Code: <code><?= htmlspecialchars($t['unique_code']) ?></code><br>
                    <a class="download-btn" href="download.php?id=<?= $t['id'] ?>">Download PDF</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
