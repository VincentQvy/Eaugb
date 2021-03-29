<?php require_once "component/config.php"; ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
    <?php
        $article = CommandSQL($pdo, 'SELECT * FROM articles WHERE name like "'.$_GET["article"].'"')[0];
        $image = $article['picture']
    ?>
    <h1><?= $article['name'] ?></h1>
    <h2><?= $article['text'] ?></h2>
    <img src='image/<?php echo $image ?>'>
    </body>
</html>