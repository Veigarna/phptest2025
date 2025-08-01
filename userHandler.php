<?php 
require_once __DIR__ . '/config.php';

            if (isset($_POST["login"])){
                $password = trim($_POST["password"]);
                $email = trim($_POST["email"]);

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $error = array();

                if (empty($email) OR empty($password)) {
                    array_push($error, "Fields Required");
                }

                if (count($error)> 0) {
                    $_SESSION['flash_errors'] = $error;
                    header("Location: login.php");
                    exit();
                }
                else
                {
                    require_once "database.php";
                    
                    if(fetchUser($email, $password, $conn)){
                        $_SESSION['flash_success'] = "Wellcome '$email'!";
                        header("Location: contact.php");
                        exit();
                    }
                    else{
                        $_SESSION['flash_warning'] = "User Not Found: '$email'!";
                        header("Location: login.php");
                        exit();
                    }
                }

                header("Location: login.php");
                exit();
            }


            if (isset($_POST["submit"])){
                $fullname = $_POST["name"];
                $password = $_POST["password"];
                $email = $_POST["email"];

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $error = array();

                if (empty($fullname) OR empty($email) OR empty($password)) {
                    array_push($error, "Fields Required");
                }
                if (strlen($password)<8) {
                    array_push($error, "Password must be at least 8 charactes");
                }

                //If email in use
                require_once "database.php";
                $rows = searchUser($email, $conn);

                if ($rows > 0) {
                    array_push($error, "Email aready in use");
                }


                if (count($error)> 0) {
                    $_SESSION['flash_errors'] = $error;
                    header("Location: index.php");
                    exit();
                    
                }
                else
                {
                    require_once "database.php";

                    if(insertUser($fullname,$email,$passwordHash,$conn)){
                        $_SESSION['flash_success'] = "In Database!";
                        header("Location: index.php");
                        exit();
                    }
                    else{
                        $_SESSION['flash_message'] = "Something went wrong!";
                        header("Location: index.php");
                        exit();
                    }
                }
            }