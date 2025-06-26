<?php
$scanner_conn = new mysqli('sql5.freesqldatabase.com','sql5786936','d1uDg5R8In','sql5786936');

$date = date('Y-m-d'); // today
$result = $scanner_conn->query("SELECT COUNT(*) as total FROM scanned_bookings WHERE DATE(scanned_at) = '$date'");
$row = $result->fetch_assoc();

echo json_encode([
    'total_scans' => $row['total']
]);
?>
