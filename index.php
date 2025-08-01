<?php
require_once __DIR__ . '/config.php';

if (isset($_SESSION["user"])) {
   header("Location: contact.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple PHP</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        
        <div class="container">
        <?php 
            if (isset($_SESSION['flash_message'])) {
                echo '<div class="alert alert-warning">' . htmlspecialchars($_SESSION['flash_message']) . '</div>';
                unset($_SESSION['flash_message']);
            }

            if (isset($_SESSION['flash_success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
                unset($_SESSION['flash_success']);
            }

            if (isset($_SESSION['flash_errors']) && is_array($_SESSION['flash_errors'])) {

                echo '<div class="alert alert-danger"><ul>';

                foreach ($_SESSION['flash_errors'] as $error) {
                    echo '<li>' . htmlspecialchars($error) . '</li>';
                }
                    echo '</ul></div>';

                unset($_SESSION['flash_errors']);  
            }
            
        ?>
            <div class="register-form">
                <h3>Register</h3>
                <form action="userHandler.php" method="post">
                    <div class="form-group">
                        <label for="name">Nimi:</label>
                        <input id="name" class="form-control"  name="name" type="text" placeholder="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Sähköposti:</label>
                        <input id="email" class="form-control"  name="email" type="text" placeholder="@example.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Salasana:</label>
                        <input id="password" class="form-control" name="password" type="password" >
                    </div>
                    <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-primary">Register</button>
                        <a class="link" href="login.php"> Aready registered?</a>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>
