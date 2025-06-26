<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    $raw = $_POST['code'];

    // Extract values using regex
    preg_match('/Booking ID:\s*(\d+)/', $raw, $match_id);
    preg_match('/Name:\s*(.+)/', $raw, $match_name);
    preg_match('/visit_date:\s*([\d-]+)/', $raw, $match_visit_date);
    preg_match('/Gender:\s*(\w+)/', $raw, $match_gender);
    preg_match('/Place:\s*(.+)/', $raw, $match_place);
    preg_match('/Nationality:\s*(.+)/', $raw, $match_nationality);
    preg_match('/Age:\s*(\d+)/', $raw, $match_age);
    preg_match('/Tourists:\s*(\d+)/', $raw, $match_tourists);
    preg_match('/Mobile:\s*([\d+]+)/', $raw, $match_mobile);
    preg_match('/Email:\s*(.+@.+)/', $raw, $match_email);
    preg_match('/Unique Code:\s*(BOOKING-\w+)/', $raw, $match_code);

    $booking_id = $match_id[1] ?? null;
    $name = $match_name[1] ?? '';
    $visit_date = $match_visit_date[1] ?? null;
    $gender = $match_gender[1] ?? '';
    $place = $match_place[1] ?? '';
    $nationality = $match_nationality[1] ?? '';
    $age = $match_age[1] ?? 0;
    $tourists = $match_tourists[1] ?? 0;
    $mobile = $match_mobile[1] ?? '';
    $email = $match_email[1] ?? '';
    $unique_code = $match_code[1] ?? '';

    $conn = new mysqli('sql5.freesqldatabase.com','sql5786936','d1uDg5R8In','sql5786936');
    if ($conn->connect_error) {
        die("❌ DB Error: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO scanned_bookings (booking_id, name, visit_date, gender, place, nationality, age, tourists, mobile, email, unique_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssiiiss", $booking_id, $name, $visit_date, $gender, $place, $nationality, $age, $tourists, $mobile, $email, $unique_code);

    if ($stmt->execute()) {
        echo "✅ Booking data saved!";
    } else {
        echo "❌ Error saving data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
