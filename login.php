<?php
// Database connection
$host = "sql5.freesqldatabase.com";
$user = "sql5786934";
$pass = "m3wWsIZkxF";
$db = "sql5786934";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$identifier = $_POST['identifier'];  // Email or mobile
$dob = $_POST['dob'];  // Date of birth

// SQL query to check if the user exists with matching email or mobile and dob
$sql = "SELECT * FROM users WHERE (email = ? OR mobile = ?) AND dob = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $identifier, $identifier, $dob);
$stmt->execute();
$result = $stmt->get_result();

// Check if a user exists with the provided identifier and dob
if ($result->num_rows === 1) {
    // If successful, start the session and redirect to the index page
    session_start();
    $user = $result->fetch_assoc();
    $_SESSION['user'] = $user;
    $_SESSION['user_name'] = $user['full_name']; // or 'email' or whichever you prefer to show

    // Redirect to index page (home page)
    header("Location: index.php");  // Change this to the desired landing page after login
    exit();  // Make sure to stop further script execution
} else {
    // If login failed, show an error message
    echo "Invalid credentials. Please try again.";
}

$stmt->close();
$conn->close();
?>
