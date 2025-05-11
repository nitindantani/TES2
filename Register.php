<?php
session_start();
$user = $_SESSION['user'] ?? null;
$placeFromURL = $_GET['place'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tourist Booking Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: linear-gradient(135deg, #a8edea 10%, #fed6e3 100%);
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    .container {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
    }
    h2 { text-align: center; margin-bottom: 20px; font-size: 22px; }
    .input-group { margin: 12px 0; }
    label { display: block; font-weight: bold; font-size: 14px; margin-bottom: 5px; }
    input, select {
      width: 100%; padding: 10px; font-size: 15px;
      border: 1px solid #ccc; border-radius: 7px;
    }
    button {
      width: 100%; padding: 12px; font-size: 16px; border: none; border-radius: 7px;
      cursor: pointer; font-weight: bold;
    }
    .pay-btn { background: #28a745; color: white; }
    .reset-btn { background: #dc3545; color: white; margin-top: 10px; }
    .note {
      background: #fff3cd;
      padding: 10px;
      border-left: 5px solid #ffeeba;
      margin-bottom: 15px;
      border-radius: 5px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Tourist Booking Form</h2>

    <?php if (!$user): ?>
      <div class="note">
        You are not logged in. You can still book manually or <a href="login.html">log in here</a>.
      </div>
    <?php endif; ?>

    <form action="booking.php" method="post" onsubmit="return validateForm()">
      <div class="input-group">
        <label for="name">Tourist Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
      </div>

      <div class="input-group">
        <label for="visit_date">Date of Visit:</label>
        <input type="date" id="visit_date" name="visit_date" required min="<?= date('d-m-y') ?>">
      </div>

      <div class="input-group">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
          <option value="">Select Gender</option>
          <option value="Male" <?= isset($user['gender']) && $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= isset($user['gender']) && $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
          <option value="Other" <?= isset($user['gender']) && $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
      </div>

      <div class="input-group">
        <label for="place">Place to Visit:</label>
        <input type="text" id="place" name="place" value="<?= htmlspecialchars($placeFromURL) ?>" required>
      </div>

      <div class="input-group">
        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" value="<?= htmlspecialchars($user['nationality'] ?? '') ?>" required>
      </div>

      <div class="input-group">
        <label for="age">Age of 1st Tourist:</label>
        <input type="number" id="age" name="age" value="<?= htmlspecialchars($user['age'] ?? '') ?>" min="1" required>
      </div>

      <div class="input-group">
        <label for="children">Number of Children (≤ 10 years):</label>
        <input type="number" id="children" name="children" value="0" min="0" oninput="updateTotal()">
      </div>

      <div class="input-group">
        <label for="adults">Number of Adults (> 10 years):</label>
        <input type="number" id="adults" name="adults" value="0" min="0" oninput="updateTotal()">
      </div>

      <div class="input-group">
        <label for="tourists">Total Tourists:</label>
        <input type="number" id="tourists" name="tourists" value="0" readonly>
      </div>

      <div class="input-group">
        <label for="mobile">Mobile Number:</label>
        <input type="tel" id="mobile" name="mobile"
          value="<?= htmlspecialchars($user['mobile'] ?? '') ?>"
          pattern="[0-9]{10}" maxlength="10" placeholder="Enter mobile number">
      </div>

      <div style="text-align: center; font-weight: bold; margin: 10px 0;">-- OR --</div>

      <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
          value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="Enter email if you have">
      </div>

      <button type="submit" class="pay-btn">Generate Ticket</button>
      <button type="button" class="reset-btn" onclick="resetForm()">Reset</button>
    </form>
  </div>

  <script>
    function validateForm() {
      const age = parseInt(document.getElementById("age").value);
      const mobile = document.getElementById("mobile").value.trim();
      const email = document.getElementById("email").value.trim();
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (isNaN(age) || age < 1) {
        alert("Age must be a positive number.");
        return false;
      }

      if (!mobile && !email) {
        alert("Please enter either a mobile number or an email address.");
        return false;
      }

      if (mobile && !/^[0-9]{10}$/.test(mobile)) {
        alert("Mobile number must be exactly 10 digits.");
        return false;
      }

      if (email && !emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
      }

      return true;
    }

    function updateTotal() {
      const children = parseInt(document.getElementById("children").value) || 0;
      const adults = parseInt(document.getElementById("adults").value) || 0;
      document.getElementById("tourists").value = children + adults;
    }

    function resetForm() {
      document.querySelector("form").reset();
      updateTotal();
    }

    window.onload = updateTotal;
  </script>
</body>
</html>
