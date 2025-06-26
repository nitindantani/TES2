<?php
$conn = new mysqli('sql5.freesqldatabase.com','sql5786934','m3wWsIZkxF','sql5786934');
$id = $_GET['id'] ?? 0;
$result = $conn->query("SELECT * FROM bookings WHERE id = $id");
$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Booking</title>
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        padding: 30px;
    }

    .edit-container {
        max-width: 600px;
        margin: auto;
        background-color: #fff;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .edit-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .edit-form label {
        display: block;
        margin-top: 12px;
        margin-bottom: 5px;
        font-weight: 600;
        color: #555;
    }

    .edit-form input,
    .edit-form select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        transition: 0.3s;
    }

    .edit-form input:focus,
    .edit-form select:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
    }

    .edit-form .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }
  </style>
</head>
<body>

<div class="edit-container">
  <h2>Edit Booking</h2>
  <form method="post" action="update_booking.php" class="edit-form">
    <input type="hidden" name="id" value="<?= $booking['id'] ?>">

    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($booking['name']) ?>" required>

    <label>Date of Visit:</label>
    <input type="date" name="visit_date" value="<?= $booking['visit_date'] ?>" required>

    <label>Gender:</label>
    <select name="gender" required>
      <option value="Male" <?= $booking['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= $booking['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
      <option value="Other" <?= $booking['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
    </select>

    <label>Place:</label>
    <input type="text" name="place" value="<?= htmlspecialchars($booking['place']) ?>" required>

    <label>Nationality:</label>
    <input type="text" name="nationality" value="<?= htmlspecialchars($booking['nationality']) ?>" required>

    <label>Age:</label>
    <input type="number" name="age" value="<?= $booking['age'] ?>" required>

    <label>Total Tourists:</label>
    <input type="number" name="tourists" value="<?= $booking['total_tourists'] ?>" required>

    <label>Adults:</label>
    <input type="number" name="adults" value="<?= $booking['adults'] ?>" required>

    <label>Children:</label>
    <input type="number" name="children" value="<?= $booking['children'] ?>" required>

    <label>Mobile:</label>
    <input type="text" name="mobile" value="<?= $booking['mobile'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $booking['email'] ?>" required>

    <div class="form-actions">
      <input type="submit" value="Update" class="btn btn-success">
      <a href="admin_bookings.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

</body>
</html>
