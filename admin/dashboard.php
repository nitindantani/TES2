<?php
header('Content-Type: application/json');

// get & validate date
$date = $_GET['date'] ?? '';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
  echo json_encode(['success'=>false,'error'=>'Invalid date']);
  exit;
}

// connect to scanner DB
// PostgreSQL connection string
$host = 'dpg-d0g4sbjuibrs73f8ot10-a.oregon-postgres.render.com';
$port = '5432';
$dbname = 'touristbooking';
$user = 'touristbooking_user';
$password = 'QbFGlPz2ytIxmfJdHSkaeO3BCSu7HBMl';

// Establish connection
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
} else {
    echo "Connection successful!";
}

// count and fetch rows stamped with created_at on that date
// assumes your scanner.booking table has a DATETIME column `created_at`
$stmt = $db->prepare("
  SELECT id,name,visit_date,place,mobile,email,
         DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS scanned_at
    FROM booking
   WHERE DATE(created_at) = ?
   ORDER BY created_at DESC
");
$stmt->bind_param('s', $date);
$stmt->execute();
$res = $stmt->get_result();

// assemble results
$bookings = [];
while ($row = $res->fetch_assoc()) {
  $bookings[] = $row;
}

// get count (or just use count($bookings))
$count = count($bookings);

echo json_encode([
  'success'  => true,
  'count'    => $count,
  'bookings' => $bookings
]);
