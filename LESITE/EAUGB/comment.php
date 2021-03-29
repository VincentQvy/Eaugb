<?php require_once "component/config.php";?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
    <?php require "component/navbar.php"; 
    $article = CommandSQL($pdo, 'SELECT * FROM articles WHERE name like "'.$_GET["article"].'"')[0];
    ?>
    <form action="addComment.php?article=<?php echo $article["name"] ?>" method="post" >
        <input type="text" name="username" id="username" placeholder='username' required>
        <input type="text" name="comment" id="comment" placeholder='comment' required>
        <input type="submit" name="submit" value="Send Comment">
    </form>
    </body>
</html>