<?php
    require_once("twitter.php");
    if (isset($_POST['submit'])) {
        publish_tweet();
    }
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <form method="POST" action="./index.php">
            <label for="tweet" name="username">Nom d'utilisateur:</label><br>
            <input type="text" name="username" id="username"><br>
            <label for="tweet" name="tweet">Message:</label><br>
            <textarea id="tweet" name="tweet" cols="50" rows="10"></textarea><br>
            <input type="submit" name="submit" id="submit" value="Envoyer">
        </form>
    </body>
</html>