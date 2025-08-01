<?php
require_once __DIR__ . '/config.php';
require __DIR__ . '/vendor/autoload.php';

$hostName="sql.freedb.tech";
$dbUser = "freedb_vtest";
$dbPassword = $_ENV['SECRET_PASS'];
$dbName = "freedb_login_register";
mysqli_report(MYSQLI_REPORT_OFF);


$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);


if (!$conn) {
    $_SESSION['flash_message'] = "Error in database connection!: " . mysqli_connect_error();
    header("Location: login.php");
    exit(); 
}



function fetchUser($email, $password, $conn){
    $sql = "SELECT email, password FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);
        $result = false;

        if ($stmt) {
            //param
            mysqli_stmt_bind_param($stmt, "s", $email);
            //execute
            mysqli_stmt_execute($stmt);
            //store result
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {

                //name params
                mysqli_stmt_bind_result($stmt, $result_email, $result_password);

                mysqli_stmt_fetch($stmt);

                if(password_verify($password, $result_password)){
                    
                    $_SESSION['flash_success'] = "Wellcome '$result_email'";

                    $_SESSION["user"] = htmlspecialchars($email);

                    $result = true;
                }
                else{
                    $_SESSION['flash_message'] = "Wrong Password";
                    $result = false;
                }
            }
            else{
                $_SESSION['flash_message'] = "Not Found";
                $result = false;
            }
        }else{
            die("Something went wrong");
        }

    return $result;
}

function searchUser($email, $conn){
    $sql = "SELECT id , email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);

    return $rows;
}

function insertUser($fullname, $email, $passwordHash, $conn){
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
    $result = false;

    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $passwordHash);
        mysqli_stmt_execute($stmt);
        $result = true;
    }else{
        
        die("Something went wrong");
        return $result;
    }

    return $result;
}


?>
