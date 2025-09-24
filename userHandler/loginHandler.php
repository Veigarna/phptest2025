<?php

require_once(__DIR__ . "/../config.php");
require (__DIR__ . "/../reCaptcha.php");
require_once(__DIR__ ."/../database.php");

$redirect = BASE_URL . "login.php";

$password = trim($_POST["password"]);
$email = trim($_POST["email"]);

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$error = array();

//reCaptcha v3
$key = $_ENV['RE_SITEKEY'];
$token = $_POST['g-recaptcha-response'] ?? '';
$action = 'submit_login';

error_log("Token: $token, Action: $action");

if (!create_assessment($key, $token, 'oppari-1758615240341', $action)) {
    $_SESSION['flash_errors'] = ['reCAPTCHA failed. Please try again.'];
}

if (empty($email) OR empty($password)) {
    array_push($error, "Fields Required");
}

if (count($error)> 0) {
    $_SESSION['flash_errors'] = $error;
}
else
{        
    if(fetchUser($email, $password, $conn)){
        $_SESSION['flash_success'] = "Wellcome '$email'!";
        $redirect = BASE_URL . "contact.php";
    }
    else{
        $_SESSION['flash_warning'] = "User Not Found: '$email'!";
    }
}
    
header("Location: " . $redirect);
exit();


