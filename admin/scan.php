<?php
$scanner_conn = new mysqli("localhost", "root", "", "scanner");

$date = date('d-m-Y'); // today
$result = $scanner_conn->query("SELECT COUNT(*) as total FROM booking WHERE DATE(scanned_at) = '$date'");
$row = $result->fetch_assoc();

echo json_encode([
    'total_scans' => $row['total']
]);
?>
