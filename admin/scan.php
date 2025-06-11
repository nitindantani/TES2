<?php
$scanner_conn = new mysqli("sql12.freesqldatabase.com", "sql12784142", "IgcSQrkBtC", "sql12784142");

$date = date('Y-m-d'); // today
$result = $scanner_conn->query("SELECT COUNT(*) as total FROM booking WHERE DATE(scanned_at) = '$date'");
$row = $result->fetch_assoc();

echo json_encode([
    'total_scans' => $row['total']
]);
?>
