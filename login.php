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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcvJ9IrAAAAANKcimxcvEMXMts0rWutrM6vY-Md"></script>
    <title>LogIn</title>
</head>
<body>
    <div id="captcha" data-sitekey="<?php echo $_ENV['RE_SITEKEY']; ?>"></div>
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
                    <form  id="loginForm" action="userHandler/loginHandler.php" method="post">
                        <div class="form-group">
                            <label for="email">Sähköposti:</label>
                            <input id="email" class="form-control"  name="email" type="text" placeholder="@example.com">
                        </div>
                        <div class="form-group">
                            <label for="password">Salasana:</label>
                            <input id="password" class="form-control" name="password" type="password" >
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                            <button id="loginBtn" name="login" type="submit" class="btn btn-primary">LogIn</button>
                            <a class="link" href="index.php"> Not registered?</a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const siteKey = document.getElementById("captcha").dataset.sitekey;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                grecaptcha.enterprise.ready(function() {
                    grecaptcha.enterprise.execute(siteKey, {action: 'submit_login'})
                        .then(function(token) {
                            document.getElementById('g-recaptcha-response').value = token;
                            form.submit();
                        })
                        .catch(function(err) {
                            console.error('reCAPTCHA epäonnistui:', err);
                            alert('reCAPTCHA-tarkistus epäonnistui.');
                        });
                });
            });
        });
    </script>
</body>
</html>