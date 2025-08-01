<?php
require_once __DIR__ . '/config.php';
/*if (isset($_SESSION["user"])) {
   header("Location: contact.php");
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>LogIn</title>
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
        <div class=box>
            <div class="info">
                <h1>Php test</h1>
                <p>Yksinkertainen php sovellus, jolla voit tehdä käyttäjän ja lähettää sähköpostia minulle.</p>
            </div>
            <div class="register-form mt-5">
                <h3>Log In</h3>
                    <form action="userHandler.php" method="post">
                        <div class="form-group">
                            <label for="email">Sähköposti:</label>
                            <input id="email" class="form-control"  name="email" type="text" placeholder="@example.com">
                        </div>
                        <div class="form-group">
                            <label for="password">Salasana:</label>
                            <input id="password" class="form-control" name="password" type="password" >
                        </div>
                        <div class="form-group">
                            <button name="login" type="submit" class="btn btn-primary">LogIn</button>
                            <a class="link" href="index.php"> Not registered?</a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    
</body>
</html>