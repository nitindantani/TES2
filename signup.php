<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'dpg-d0g4sbjuibrs73f8ot10-a.oregon-postgres.render.com';
$port = '5432';
$dbname = 'touristbooking';
$user = 'touristbooking_user';
$password = 'QbFGlPz2ytIxmfJdHSkaeO3BCSu7HBMl';

// Establish connection to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
} else {
    // Connection successful
    // Uncomment the next line if you want to display this message for debugging purposes
    // echo "Connection successful!";
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $full_name = trim($_POST['full_name']);
    $dob = trim($_POST['dob']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $nationality = trim($_POST['nationality']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        die("Invalid mobile number.");
    }
    if (!is_numeric($age) || $age < 1) {
        die("Age must be a valid positive number.");
    }

    // SQL insert query (with placeholders for parameters)
    $sql = "INSERT INTO users (full_name, dob, age, gender, nationality, mobile, email) 
            VALUES ($1, $2, $3, $4, $5, $6, $7)";

    // Prepare the query
    $result = pg_prepare($conn, "insert_user", $sql);

    if ($result === false) {
        die("Error preparing the SQL query: " . pg_last_error($conn));
    }

    // Execute the prepared query with actual values
    $result = pg_execute($conn, "insert_user", array($full_name, $dob, $age, $gender, $nationality, $mobile, $email));

    if ($result) {
        // Redirect to the homepage or display a success message
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'index.php';
              </script>";
    } else {
        // Display error if the query execution fails
        echo "Error: " . pg_last_error($conn);
    }

    // Close the database connection
    pg_close($conn);
}
?>
