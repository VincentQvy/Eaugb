<?php require_once "component/config.php"; ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--Import Google Icon Font, Framework CSS : Materialize, and our CSS-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body class="<?php echo $_SESSION['theme'] ?>">
    <?php 
    $project = CommandSQL($pdo, 'SELECT * FROM projects WHERE name like "'.$_GET["project"].'"')[0];
    $images = explode(";", $project["images"]);
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    ?>

    <?php require "php/nav.php" ?>

    <main>
      <!-- Debut Fond -->
      <div class="parallax-container margin3 center valign-wrapper">
        <div class="container">
            <h1 class="<?php echo explode(" ",$_SESSION['theme'])[1] ?>"><?php echo $project["name"] ?></h1>
            <?php
            $lien = "#";
            if ($project["lien"] != "") {
              ?>
              <a class="btn-large bleu-perso" href="projects/<?php echo $project["lien"]; ?>" download>Download</a>
              <?php
            }
            ?>
        </div>
        <div class="parallax opacity4">
          <img src="img/<?php echo $images[0]; ?>">
        </div>
      </div>

      <!-- Description image ect -->
      <div class="container <?php echo $_SESSION['theme'] ?>">
        <p class="flow-text"><?php echo $project["description"] ?></p>
        <!-- carrousel images -->
        <div class="carousel carousel-slider">
          <?php 
          $count = 0;
              foreach ($images as $image) {    
                  $count += 1;
                  ?>
                  <div class="carousel-item <?php echo $_SESSION['theme'] ?>" href="#<?php echo $f->format($count); ?>!">
                      <img src="img/<?php echo $image ?>">
                  </div>
                  <?php 
              }
          ?>
        </div>
      </div>

      <!-- Commentaire -->
      <div class="container <?php echo $_SESSION['theme'] ?>">
        <h2 id="title_comments">Comment : </h2>
        <p id="reply_to"></p>
        <!-- Send -->
        <div class="row">
          <div class="input-field col s12 m6">
            <i class="material-icons prefix">account_circle</i>
            <input id="pseudo" type="text" class="validate">
            <label for="pseudo">Pseudo</label>
          </div>
          <div class="input-field col s12">
            <textarea id="comment" class="materialize-textarea"></textarea>
            <label for="comment">Comment</label>
          </div>
          <div class="col s12 right-align">
            <p class="btn-large" id="enter">Enter</p>
          </div>
        </div>
        <!-- View -->
        <div class="row">
          <div id="comments">
            <?php
            $allComments = CommandSQL($pdo, "SELECT * FROM avis WHERE project_id = ".$project["id"]);
            $_SESSION["allComments"] = array();
            foreach ($allComments as $allComment) {
              $_SESSION["allComments"][$allComment["id"]] = $allComment;
            }
            $comments = CommandSQL($pdo, "SELECT * FROM avis WHERE project_id = ".$project["id"]." AND parent_id = 0 ORDER BY date DESC LIMIT 3");
            $tableReplys = CommandSQL($pdo, "SELECT * FROM avis WHERE project_id = ".$project["id"]." AND parent_id != 0");
            $replys = array();
            foreach ($tableReplys as $reply) {
              if (array_key_exists($reply["parent_id"], $replys)) {
                $replys[$reply["parent_id"]][] = $reply;
              }else{
                $replys[$reply["parent_id"]] = array();
                $replys[$reply["parent_id"]][] = $reply;
              }
            }
            if (count($allComments) > 0) {
              foreach ($comments as $comment) {
                ?>
                <div id="commentId<?php echo $comment["id"] ?>">
                  <h2 class="col s12"><?php echo $comment["pseudo"] ?></h2>
                  <p class="col s12"><?php echo $comment["date"] ?></p>
                  <p class="flow-text col s12"><?php echo $comment["comment"] ?></p>
                  <div class="col s12 right-align">
                    <p class="btn-large reply" id="replyId<?php echo $comment["id"] ?>">Reply</p>
                  </div>
                </div>
                <?php
                $numReply = 1;
                $idParent = $comment["id"];
                if (array_key_exists($idParent, $replys)) {
                  foreach ($replys[$idParent] as $reply) {
                    ?>
                    <div id="commentId<?php echo $reply["id"] ?>">
                      <h2 class="col s11 offset-s1"><?php echo $reply["pseudo"] ?></h2>
                      <p class="col s11 offset-s1"><?php echo $reply["date"] ?></p>
                      <p class="flow-text col s11 offset-s1"><?php echo $reply["comment"] ?></p>
                    </div>
                    <?php
                  }
                }
              }
            }else{
              ?>
              <p class='flow-text'>Soyez le premier a ecrire un commentaire sur ce projet !</p>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </main>

    <?php require "php/footer.php" ?>

    <script src="js/jquery.min.js" charset="utf-8"></script>
    <script src="js/materialize.min.js" charset="utf-8"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var projectId = <?php echo json_encode($project["id"]); ?>;
        loading = false;
        offset = 3;
        var replyId = 0;

        // Materialize
        $('.sidenav').sidenav();
        $('.parallax').parallax();
        $('.carousel.carousel-slider').carousel({
          fullWidth: true,
          indicators: true
        });

        // Send Commentaire
        $("#enter").on("click", function() {
          var pseudo = $('#pseudo').val(); 
          var comment = $('#comment').val();

          if(pseudo != "" && comment != ""){ 
            $.ajax({
              url : "php/addComment.php", 
              type : "POST", 
              data : "pseudo=" + pseudo + "&comment=" + comment + "&project_id=" + projectId + "&reply_id="+ replyId,
              success: function(data) {
                offset++;
                if (replyId == 0) {
                  $(data).prependTo("#comments");
                }else{
                  $("#commentId"+replyId).after(data);
                }
                onClickReply()
              }
            });
          }
        });
        
        // Auto Load
        $(window).on('scroll',function() { 
          if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            if(loading===false){
              loading=true;
              $.ajax({
                url : "php/majComment.php", 
                type : "POST", 
                data : "project_id=" + projectId + "&offset="+offset,
                success: function(data) {
                  $("#comments").append(data);
                  loading=false;
                  offset++;
                  onClickReply()
                }
              });
            }
          }
        });

        // Reply
        function onClickReply() {
          $(".reply").unbind('click');
          $(".reply").on("click", function(e) {
            replyId = e.target.id.replace("replyId", "");
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#title_comments").offset().top
            }, 500)
            ;$.ajax({
                url : "php/get-data-allComments.php", 
                type : "POST", 
                data : "id=" + replyId,
                success: function(data) {
                  data = JSON.parse(data);
                  $("#reply_to").html("Reply to '" + data["pseudo"] + "' saying : " + data["comment"] + " <p class='btn' id='suppr_reply'>Quit</p>");
                  $("#suppr_reply").on("click", function(e) {
                    $("#reply_to").html("");
                    replyId = 0;
                  });
                }
              });
          });
        }
        onClickReply()
      });
    </script>
</body>
</html>