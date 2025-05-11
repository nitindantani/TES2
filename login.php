<?php
// Database connection
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
