<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $visit_date = $_POST['visit_date'];
    $gender = $_POST['gender'];
    $place = $_POST['place'];
    $nationality = $_POST['nationality'];
    $age = $_POST['age'];
    $tourists = $_POST['tourists'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    // Update booking in the database
    $conn = new mysqli("sql12.freesqldatabase.com", "sql12783951", "AY3kzpvH9n", "sql12783951");
    $sql = "UPDATE bookings SET name = ?, visit_date = ?, gender = ?, place = ?, nationality = ?, age = ?, total_tourists = ?, adults = ?, children = ?, mobile = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $name, $visit_date, $gender, $place, $nationality, $age, $tourists, $adults, $children, $mobile, $email, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: admin_bookings.php?status=success");
    } else {
        header("Location: admin_bookings.php?status=error");
    }
}
?>
