<?php 
require_once "component/config.php"; 
$article = CommandSQL($pdo, 'SELECT * FROM articles WHERE name like "'.$_GET["article"].'"')[0];
$date = GETDATE();
$dateSent = $date['year'] . '-' . $date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'].':'.$date['seconds'];
var_dump($dateSent);
CommandSecureSQL($pdo, 
    "INSERT INTO `comments`(`name`, `comment`, `article_id`, `date`) VALUES (:username,:comment,:article_id,:date)", 
    array("article_id" => $article["id"],
          "username" => $_POST["username"],
          "comment" => $_POST["comment"],
          "date" => $dateSent,
    ));
header('Location: http://localhost/Batiste%20Vincent/EAUGB/EAUGB/article.php?article='.$_GET["article"])
?>