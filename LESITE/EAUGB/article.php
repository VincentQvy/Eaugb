<?php require_once "component/config.php"; ?>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
    <?php require "component/navbar.php"; ?>
    <?php
        $article = CommandSQL($pdo, 'SELECT * FROM articles WHERE name like "'.$_GET["article"].'"')[0];
        $article_id = $article['id'];
        $comments = CommandSQL($pdo, 'SELECT * FROM comments WHERE article_id = ' .$article_id);
        $image = $article['picture'];
    ?>
    <h1><?= $article['name'] ?></h1>
    <h2><?= $article['text'] ?></h2>
    <img src='image/<?php echo $image ?>'>
    <?php if(empty($comments)){?>
        <h3>Soyez le premier à commenter</h3>
    <?php }else{
        foreach ($comments as $comment) {?>
            <p><?php echo $comment["name"] ?></p>
            <p><?php echo $comment["comment"] ?></p>
            <p><?php echo $comment["date"] ?></p>
            <?php
            }
        } ?>
    <form action="comment.php?article=<?php echo $article["name"] ?>" method="post" >
        <button type='submit'>Comment</button>
    </form>
    </body>
</html>