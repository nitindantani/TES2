<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "sql206.infinityfree.com";
$user = "if0_38952666";
$pass = "Nitin3001n";
$db = "if0_38952666_touristbooking";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        die("Invalid mobile number.");
    }

    // SQL insert
    $sql = "INSERT INTO users (full_name, dob, age, gender, nationality, mobile, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssissss", $full_name, $dob, $age, $gender, $nationality, $mobile, $email);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
