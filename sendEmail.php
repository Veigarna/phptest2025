<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    // Jos ei POST, ohjataan pois
    header("Location: contact.php");
    exit();
}

$message = htmlspecialchars(trim($_POST['message'] ?? ''));
$email = htmlspecialchars($_SESSION["user"]);

if ($message === '') {
    $_SESSION['flash_error'] = 'Message required.';
    header("Location: contact.php");
    exit();
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SECRET_EMAIL'];
    $mail->Password = $_ENV['SECRET_KEY']; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($_ENV['SECRET_EMAIL'], "website");
    $mail->addAddress($_ENV['SECRET_EMAIL'], "website");

    $mail->Subject = "New Contact Form Submission";
    $mail->Body = "Email: $email\nMessage: $message";

    //$mail->SMTPDebug = 2;
    //$mail->Debugoutput = 'html';

    $mail->send();

    $_SESSION['flash_message'] = "Message sent succesfully from $email.";

} catch (Exception $e) {
    $_SESSION['flash_error'] = "Something went wrong: {$mail->ErrorInfo}";
}

header("Location: contact.php");
exit();
