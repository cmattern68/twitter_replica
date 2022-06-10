<?php

require_once("pdo.php");

function get_tweets() {
    return [];
}

function publish_tweet() {
    global $database;
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $tweet = filter_var(trim($_POST['tweet']), FILTER_SANITIZE_STRING);
    if (empty($username)) {
        echo "Erreur: Le nom d'utilisateur est obligatoire.";
    } else if (empty($tweet)) {
        echo "Erreur: Le tweet est obligatoire.";
    } else {
        $req = $database->prepare("INSERT INTO tweet (username, message, date), VALUES (:username, :tweet, NOW())");
        $req->bindParam(":username", $username);
        $req->bindParam(":tweet", $tweet);
        $req->execute();
        #$req->execute(array(
        #    ":username" => $username,
        #    ":tweet", $tweet
        #));
        echo "Tweet posté !";
    }
}