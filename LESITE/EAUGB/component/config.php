<?php
session_start();

$pdo = new PDO(
    'mysql:host=localhost;dbname=eaugb;',
    'root',
    '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

function CommandSQL($pdo, $sql) {
    $pre = $pdo->prepare($sql);
    $pre->execute();
    return $pre->fetchAll(PDO::FETCH_ASSOC);
}

function CommandSecureSQL($pdo, $sql, $array) {
    $pre = $pdo->prepare($sql);
    $pre->execute($array);
}

?>