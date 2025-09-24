<?php
require_once(__DIR__ . "/../config.php");
require (__DIR__ . "/../reCaptcha.php");
require_once(__DIR__ ."/../database.php");

$redirect = BASE_URL . "index.php";


$secret = $_ENV['RE_PASS'];
$token = $_POST['g-recaptcha-response'] ?? '';
$fullname = $_POST["name"];
$password = $_POST["password"];
$email = $_POST["email"];
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$error = array();

//reCaptcha
if (!$token) {
    $_SESSION['flash_message'] = "reCAPTCHA invalid!";
}

$response = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret=" 
    . $secret . "&response=" . $token
);

$result = json_decode($response, true);

if ($result['success'] == true) {
    
    if (empty($fullname) OR empty($email) OR empty($password)) {
        array_push($error, "Fields Required");
    }
    if (strlen($password)<8) {
        array_push($error, "Password must be at least 8 charactes");
    }

    //If email in use
    $rows = searchUser($email, $conn);

    if ($rows > 0) {
        array_push($error, "Email aready in use");
    }


    if (count($error)> 0) {
        $_SESSION['flash_errors'] = $error;
        header("Location: " . $redirect);
        exit();
    }
    else
    {
        if(insertUser($fullname,$email,$passwordHash,$conn)){
            $_SESSION['flash_success'] = "Registered!";
            header("Location: " . $redirect);
            exit();
        }
        else{
            $_SESSION['flash_message'] = "Something went wrong!";
            header("Location: " . $redirect);
            exit();
        }
    }

} else {
    $_SESSION['flash_message'] = "reCAPTCHA invalid!";
    header("Location: " . $redirect);
    exit();
}
