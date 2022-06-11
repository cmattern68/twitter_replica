<?php
    session_start();
    require_once("twitter.php");
    if (isset($_GET['delete_tweet'])) {
        delete_tweet();
    }
    $tweets = [];
    if (isset($_GET['search'])) {
        $tweets = search_tweet();
    } else {
        $tweets = get_tweets();
    }
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
		<?php
            if (isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo $error . "<br>";
                }
            } else if (isset($_SESSION['success'])) {
                foreach ($_SESSION['success'] as $success) {
                    echo $success . "<br>";
                }
            }
            session_unset();
			if (isset($_POST['submit'])) {
				publish_tweet();
			}
		?>
        <form method="GET" action="./index.php">
            <label for="search" name="search">Recherche:</label><br>
            <input type="text" name="search" id="search"><br>
            <input type="submit" id="submit" value="Envoyer">
        </form>
        <hr>
        <form method="POST" action="./index.php">
            <label for="tweet" name="username">Nom d'utilisateur:</label><br>
            <input type="text" name="username" id="username"><br>
            <label for="tweet" name="tweet">Message:</label><br>
            <textarea id="tweet" name="tweet" cols="50" rows="10"></textarea><br>
            <input type="submit" name="submit" id="submit" value="Envoyer">
        </form>
        <hr>
		<?php
            $count = count($tweets);
            if ($count > 0) {
                ?>
                <p class="result"><?php echo $count; ?> résultats.</p>
                <hr>
                <?php
                foreach ($tweets as $tweet) {
                    $id = $tweet['id'];
                    $username = "@".$tweet['username'];
                    $message = $tweet['message'];
                    $post_time = "Posté par ". $username ." le ". date("d/m/Y à H:i", strtotime($tweet['time']));
                    ?>
                        <div class="tweet" id="tweet-<?php echo $id; ?>">
                            <p class="message"><?php echo $message; ?></p>
                            <p class="post_time"><?php echo $post_time; ?></p>
                            <a href="./index.php?delete_tweet=<?php echo $id; ?>">Supprimer le tweet ?</a>
                        </div>
                        <hr>
                    <?php
                }
            } else {
                echo "Pas de tweets pour le moment ...";
            }
		?>
    </body>
</html>