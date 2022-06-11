<?php
    require_once("twitter.php");
    if (isset($_GET['delete_tweet'])) {
        delete_tweet();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="style.css" rel="stylesheet">
        <title>Twitter</title>
        <link rel="icon" type="image/png" href="logo-twitter.png">
    </head>
    <body>
        <div class="home">
            <a href="index.php">Accueil</a>
        </div>
        <div class="search-form form">
            <?php
            $tweets = [];
            if (isset($_GET['search'])) {
                $tweets = search_tweet();
            } else {
                $tweets = get_tweets();
            }

            if (isset($_SESSION['msg'])) {
                foreach ($_SESSION['msg'] as $msg) {
                    echo $msg;
                }
                session_unset();
            }
            ?>
            <form method="GET" action="./index.php">
                <label for="search" name="search">Recherche:</label>
                <input type="text" name="search" id="search" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
                <input type="submit" id="submit" value="Envoyer">
            </form>
        </div>
        <div class="container">
            <div class="post-form form">
                <?php
                    if (isset($_POST['submit'])) {
                        publish_tweet();
                    }
                ?>
                <form method="POST" action="">
                    <label for="tweet" name="username">Nom d'utilisateur:</label><br>
                    <input type="text" name="username" id="username"><br>
                    <label for="tweet" name="tweet">Message:</label><br>
                    <textarea id="tweet" name="tweet" cols="50" rows="10"></textarea><br>
                    <input type="submit" name="submit" id="submit" class="submit-tweet" value="Envoyer">
                </form>
            </div>
            <div class="tweets">
                <?php
                    $count = count($tweets);
                    if ($count > 0) {
                ?>
                        <p class="result"><?php echo $count; ?> résultat(s).</p>
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
            </div>
        </div>
    </body>
</html>