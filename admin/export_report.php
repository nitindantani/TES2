<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$from   = $_GET['from'] ?? '';
$to     = $_GET['to'] ?? '';
$format = strtolower($_GET['format'] ?? 'csv');

// 1) Validate
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
    die("Invalid date format.");
}
if (!in_array($format, ['csv', 'pdf'])) {
    die("Invalid format.");
}

// 2) DB query
$db = new mysqli("sql12.freesqldatabase.com", "sql12784142", "IgcSQrkBtC", "sql12784142");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$stmt = $db->prepare("
    SELECT id, name, visit_date, mobile, email,
           DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS scanned_at
      FROM booking
     WHERE DATE(created_at) BETWEEN ? AND ?
     ORDER BY created_at ASC
");
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = $r;
}
$stmt->close();
$db->close();

// 3A) CSV
if ($format === 'csv') {
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename=\"scan_report_{$from}_to_{$to}.csv\"");

    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Name', 'Visit Date', 'Mobile', 'Email', 'Scanned At']);
    foreach ($rows as $r) {
        fputcsv($out, [$r['id'], $r['name'], $r['visit_date'], $r['mobile'], $r['email'], $r['scanned_at']]);
    }
    fclose($out);
    exit;
}

// 3B) PDF
require_once('TCPDF/tcpdf.php');
$pdf = new TCPDF();
$pdf->SetTitle("Scan Report $from to $to");
$pdf->AddPage();

$html = "<h2>Scan Report: $from to $to</h2>
<table border=\"1\" cellpadding=\"4\">
  <thead>
    <tr style=\"background-color:#f2f2f2;\">
      <th>ID</th><th>Name</th><th>Visit Date</th>
      <th>Mobile</th><th>Email</th><th>Scanned At</th>
    </tr>
  </thead><tbody>";

foreach ($rows as $r) {
    $html .= "<tr>
      <td>{$r['id']}</td>
      <td>".htmlspecialchars($r['name'])."</td>
      <td>{$r['visit_date']}</td>
      <td>{$r['mobile']}</td>
      <td>".htmlspecialchars($r['email'])."</td>
      <td>{$r['scanned_at']}</td>
    </tr>";
}

$html .= "</tbody></table>";
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output("scan_report_{$from}_to_{$to}.pdf", 'D');
exit;
