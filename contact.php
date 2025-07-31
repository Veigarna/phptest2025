<?php
require_once __DIR__ . '/config.php';



if (!isset($_SESSION["user"])) {
    $_SESSION['flash_message'] = "Logged Out!";
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">

        <?php
        
        if (isset($_SESSION['flash_message'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['flash_message']) . '</div>';
            unset($_SESSION['flash_message']);
        }
        if (isset($_SESSION['flash_success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
            unset($_SESSION['flash_success']);
        }
        if (isset($_SESSION['flash_error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['flash_error']) . '</div>';
            unset($_SESSION['flash_error']);
        }
        ?>

        <div class="col">
            <div class="row">
                <div class="box">
                    <h2>Tervetuloa</h2>
                    <p>Tällä lomakkeella voit laittaa minulle henkilökohtaista viestiä / palutetta. Lähettämiseen käytetään käyttäjäsi sähköpostia.</p>
                </div>
            </div>
        </div>
            
        <div class="col">
            <div class="row">
                <div class="box">
                    <form action="sendEmail.php" method="post">
                    <div class="form-group">
                        <label for="password">Viesti:</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Kirjoita viesti..."></textarea>
                    </div>
                    <div class="form-group">
                        <button name="send" type="submit" class="btn btn-primary">Send</button>
                        <a href="logout.php"class="btn btn-primary mr-5">Log out</a>
                        
                    </div>
                </form>
                </div>
            </div>
        </div>
            
    </div>
    <script>

        //force reload if returning to this site with <-
        window.onpageshow = function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        };
</script>
    
</body>
</html>