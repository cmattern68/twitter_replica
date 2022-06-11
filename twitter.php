<?php

require_once("pdo.php");

function get_tweets() {
	global $database;
	$req = $database->prepare("SELECT * FROM tweet ORDER BY time DESC");
	$req->execute();
	return $req->fetchAll();
}

function publish_tweet() {
    global $database;
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $tweet = filter_var(trim($_POST['tweet']), FILTER_SANITIZE_STRING);
    if (empty($username)) {
        echo "Le nom d'utilisateur est obligatoire.";
    } else if (empty($tweet)) {
        echo "Le tweet est obligatoire.";
	} else if (strlen($username) > 280) {
        echo "Le nom d'utilisateur doit faire maximum 255 caractères.";
	} else if (strlen($tweet) > 280) {
        echo "Le tweet doit faire maximum 280 caractères.";
    } else {
        $req = $database->prepare("INSERT INTO tweet (username, message, time) VALUES (:username, :tweet, NOW())");
        $req->execute(array(
            ":username" => $username,
            ":tweet" => $tweet
        ));
        echo "Le tweet a bien été ajouté !";
    }
}

function delete_tweet() {
    global $database;
    $id = $_GET['delete_tweet'];
    if (!is_numeric($id)) {
        echo "Le tweet à supprimer n'est pas valide.";
    } else {
        $req = $database->prepare("DELETE FROM tweet WHERE id=:id");
        $req->execute(array(
            ":id" => $id
        ));
        echo "Le tweet a bien été supprimé !";
    }
}

function search_tweet() {
    global $database;
    $search = filter_var(trim($_GET['search']), FILTER_SANITIZE_STRING);
    if (empty($search) ||strlen($search) < 2) {
        echo "Le tweet recherché doit faire au moins 2 caractères.";
        return array();
    } else {
        $req = $database->prepare("SELECT * FROM tweet WHERE message LIKE :query");
        $req->execute(array(
            ":query" => "%".$search."%"
        ));
        return $req->fetchAll();
    }
}