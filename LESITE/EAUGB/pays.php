<?php require_once "component/config.php"; ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <?php $pays = CommandSQL($pdo, 'SELECT * FROM countries WHERE id like "'.$_POST["chooseCountry"].'"'); ?>
        <?php $article = CommandSQL($pdo, 'SELECT * FROM articles WHERE country_id like "'.$_POST["chooseCountry"].'"');?>
        <?php require "component/navbar.php"; ?>
        </br>
        <?php foreach ($article as $article) { ?>
            <a href="article.php?article=<?php echo $article["name"] ?>"><?php echo $article["name"] ?></a>
            </br>
        <?php } ?>
    </body>
</html>