<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load QR code library
include 'phpqrcode/qrlib.php';

// Load TCPDF
require_once('TCPDF/tcpdf.php');

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // === 1) Fetch & sanitize ===
    $name        = htmlspecialchars($_POST['name']        ?? '');
    $visit_date  = $_POST['visit_date']                     ?? '';
    $gender      = $_POST['gender']                         ?? '';
    $place       = htmlspecialchars($_POST['place']       ?? '');
    $nationality = htmlspecialchars($_POST['nationality'] ?? '');
    $age         = intval($_POST['age']                    ?? 0);
    $children    = intval($_POST['children']               ?? 0);
    $adults      = intval($_POST['adults']                 ?? 0);
    $mobile      = $_POST['mobile']                         ?? '';
    $email       = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $unique_code = uniqid('BOOKING-');
    $total       = $children + $adults;

    // === 2) Validate required ===
    if (!$name || !$visit_date || !$gender || !$place || !$nationality || !$age || !$email) {
        die("❌ All fields including Visit Date are required.");
    }

    // === 3) Insert into bookings table ===
    $sql = "INSERT INTO bookings
                (name, visit_date, gender, place, nationality, age, total_tourists, children, adults, mobile, email, unique_code)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) die("Prepare failed: " . $conn->error);

    // bind types: s=string, i=int
    $stmt->bind_param(
        "sssssiiissss",
        $name,
        $visit_date,
        $gender,
        $place,
        $nationality,
        $age,
        $total,
        $children,
        $adults,
        $mobile,
        $email,
        $unique_code
    );

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        // === 4) Fetch the record back ===
        $select = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
        $select->bind_param("i", $last_id);
        $select->execute();
        $booking = $select->get_result()->fetch_assoc();
        $select->close();

        // === 5) QR‐code with full info ===
        $qr_text = 
            "Booking ID: "    . $booking['id'] . "\n" .
            "Name: "          . $booking['name'] . "\n" .
            "Visit Date: "    . $booking['visit_date'] . "\n" .
            "Gender: "        . $booking['gender'] . "\n" .
            "Place: "         . $booking['place'] . "\n" .
            "Nationality: "   . $booking['nationality'] . "\n" .
            "Age: "           . $booking['age'] . "\n" .
            "Children: "      . $booking['children'] . "\n" .
            "Adults: "        . $booking['adults'] . "\n" .
            "Total Tourists: ". $booking['total_tourists'] . "\n" .
            "Mobile: "        . $booking['mobile'] . "\n" .
            "Email: "         . $booking['email'] . "\n" .
            "Unique Code: "   . $booking['unique_code'];

        $qr_dir  = 'qrcodes/';
        if (!file_exists($qr_dir)) mkdir($qr_dir, 0755, true);
        $qr_file = $qr_dir . 'booking_' . $last_id . '.png';
        QRcode::png($qr_text, $qr_file, QR_ECLEVEL_L, 4);

        // === 6) PDF ticket with unique code + QR ===
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0, "Booking Confirmation\n\nYour Unique Code: $unique_code");
        $pdf->Image($qr_file, 110, 30, 60, 60, 'PNG');
        $pdf_content = $pdf->Output('', 'S');

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

        $stmt_pdf = $pdf_conn->prepare(
            "INSERT INTO booking_pdfs (booking_id, pdf_data) VALUES (?, ?)"
        );
        $stmt_pdf->bind_param("is", $last_id, $pdf_content);
        $stmt_pdf->execute();
        $stmt_pdf->close();
        $pdf_conn->close();

        // === 8) Email the PDF ticket ===
        if ($email) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'ticketlessentrysystembyteamx@gmail.com';
                $mail->Password   = 'pdikzlmjxehowpib';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('ticketlessentrysystembyteamx@gmail.com', 'Tourist Booking');
                $mail->addAddress($email, $name);
                $mail->isHTML(true);
                $mail->Subject = 'Your Booking Confirmation';
                $mail->Body    = "<h2>Hi $name,</h2>
                                  <p>Thank you for booking!</p>
                                  <p>Your unique booking code is: <strong>$unique_code</strong></p>
                                  <p>Your PDF ticket is attached.</p>";
                $mail->addStringAttachment($pdf_content, 'booking.pdf');
                $mail->send();
            } catch (Exception $e) {
                echo "❌ Email Error: " . $mail->ErrorInfo;
            }
        }

        // === 9) Redirect on success ===
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "❌ DB Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
