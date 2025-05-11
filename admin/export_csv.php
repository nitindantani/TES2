<?php
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

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="tourist_bookings.csv"');

$output = fopen("php://output", "w");

// Column headers
fputcsv($output, ['ID', 'Name', 'DOV', 'Gender', 'Place', 'Nationality', 'Age','children' ,'adults','Total Tourists', 'Mobile', 'Email', 'Unique Code', 'Created At']);

$result = $conn->query("SELECT * FROM booking ORDER BY id ASC");

while ($row = $result->fetch_assoc()) {
    // Format fields to prevent Excel issues
    $visit_date = date('Y-m-d', strtotime($row['visit_date']));
    $created_at = date('Y-m-d H:i:s', strtotime($row['created_at']));
    $mobile = "\t" . $row['mobile']; // Forces Excel to treat as text
    $unique_code = "\t" . $row['unique_code']; // Same for code

    fputcsv($output, [
        $row['id'],
        $row['name'],
        $visit_date,
        $row['gender'],
        $row['place'],
        $row['nationality'],
        $row['age'],
        $row['children'],
        $row['adults'],
        $row['total_tourists'],
        $mobile,
        $row['email'],
        $unique_code,
        $created_at
    ]);
}

fclose($output);
?>
