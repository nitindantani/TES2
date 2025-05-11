<?php if (isset($_GET['status'])): ?>
    <div style="padding: 10px; border-radius: 5px; margin-bottom: 10px;
                color: white;
                background-color: <?= $_GET['status'] === 'success' ? 'green' : 'red' ?>;">
        <?= $_GET['status'] === 'success' ? '✅ Booking updated successfully!' : '❌ Update failed. Please try again.' ?>
    </div>
<?php endif; ?>

<?php
// admin_bookings.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to DB
$conn = new mysqli("localhost", "root", "", "TouristBooking");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch all bookings, ordering by ID
$sql = "SELECT * FROM bookings ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px 15px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background: #2e86de;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            background: #2e86de;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .btn:hover {
            background: #1b4f72;
        }
    </style>
</head>
<body>

<h1>📋 Admin Panel - Tourist Bookings</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Visit Date</th>
        <th>Gender</th>
        <th>Place</th>
        <th>Nationality</th>
        <th>Age</th>
        <th>Total Tourists</th>
        <th>Adults</th>
        <th>Children</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Unique Code</th>
        <th>Booked At</th>
        <th>Download</th>
        <th>Edit</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['visit_date']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['place']) ?></td>
                <td><?= htmlspecialchars($row['nationality']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?></td>
                <td><?= htmlspecialchars($row['total_tourists']) ?></td>
                <td><?= htmlspecialchars($row['adults']) ?></td>
                <td><?= htmlspecialchars($row['children']) ?></td>
                <td><?= htmlspecialchars($row['mobile']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><strong><?= htmlspecialchars($row['unique_code']) ?></strong></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td><a href="download.php?id=<?= $row['id'] ?>" target="_blank" class="btn">Download</a></td>
                <td><a href="edit_booking.php?id=<?= $row['id'] ?>" class="btn">Edit</a></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="16" style="text-align:center;">No bookings found.</td></tr>
    <?php endif; ?>
</table>

<div class="actions">
    <form action="export_csv.php" method="post" style="display:inline;">
        <button class="btn">Export CSV</button>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
