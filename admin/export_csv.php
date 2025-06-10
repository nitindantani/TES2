<?php
$conn = new mysqli("sql12.freesqldatabase.com", "sql12783951", "AY3kzpvH9n", "sql12783951");

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="tourist_bookings.csv"');

$output = fopen("php://output", "w");

// Column headers
fputcsv($output, ['ID', 'Name', 'DOV', 'Gender', 'Place', 'Nationality', 'Age','children' ,'adults','Total Tourists', 'Mobile', 'Email', 'Unique Code', 'Created At']);

$result = $conn->query("SELECT * FROM bookings ORDER BY id ASC");

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
