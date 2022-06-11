<?php

require_once("pdo.php");

session_start();

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
        $_SESSION['msg'][] = "<div class=\"error\">Le nom d'utilisateur est obligatoire.</div>";
    } else if (empty($tweet)) {
        $_SESSION['msg'][] = "<div class=\"error\">Le tweet est obligatoire.</div>";
	} else if (strlen($username) > 280) {
        $_SESSION['msg'][] = "<div class=\"error\">Le nom d'utilisateur doit faire maximum 255 caractères.</div>";
	} else if (strlen($tweet) > 280) {
        $_SESSION['msg'][] = "<div class=\"error\">Le tweet doit faire maximum 280 caractères.</div>";
    } else {
        $req = $database->prepare("INSERT INTO tweet (username, message, time) VALUES (:username, :tweet, NOW())");
        $req->execute(array(
            ":username" => $username,
            ":tweet" => $tweet
        ));
        $_SESSION['msg'][] = "<div class=\"success\">Le tweet a bien été ajouté !</div>";
    }
    header("Location: index.php");
}

function delete_tweet() {
    global $database;
    $id = $_GET['delete_tweet'];
    if (is_numeric($id)) {
        $req = $database->prepare("DELETE FROM tweet WHERE id=:id");
        $req->execute(array(
            ":id" => $id
        ));
        $_SESSION['msg'][] = "<div class=\"success\">Le tweet a bien été supprimé !</div>";
    }
    header("Location: index.php");
}

function search_tweet() {
    global $database;
    $search = filter_var(trim($_GET['search']), FILTER_SANITIZE_STRING);
    if (empty($search) ||strlen($search) < 2) {
        echo "<div class=\"error\">Le tweet recherché doit faire au moins 2 caractères.</div>";
        return array();
    } else {
        $req = $database->prepare("SELECT * FROM tweet WHERE message LIKE :query");
        $req->execute(array(
            ":query" => "%".$search."%"
        ));
        return $req->fetchAll();
    }
}