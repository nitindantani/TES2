<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to DB
$conn = new mysqli('sql5.freesqldatabase.com','sql5786934','m3wWsIZkxF','sql5786934');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the most recent booking ID
$result = $conn->query("SELECT booking_id FROM booking_pdfs ORDER BY booking_id DESC LIMIT 1");

if ($result && $row = $result->fetch_assoc()) {
    $booking_id = $row['booking_id'];

    // Fetch binary PDF data
    $stmt = $conn->prepare("SELECT pdf_data FROM booking_pdfs WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($pdf_data);
        $stmt->fetch();

        // Send correct headers
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=booking_$booking_id.pdf");
        header("Content-Length: " . strlen($pdf_data));
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Transfer-Encoding: binary");

        // Output the PDF
        echo $pdf_data;
        exit;
    } else {
        echo "❌ No PDF found for the latest booking ID.";
    }

    $stmt->close();
} else {
    echo "❌ No bookings found in the database.";
}

$conn->close();
?>
