<?php include "header.php" ?>
  <div id="lightSide">
  <div class="content"><?php echo $results['article']->content?></div>
    <h2 id="pubDate">Published on <?php echo date('j F Y', $results['article']->pubDate)?></h2>
    <p><a href="./?action=archive">To the jedi archive</a></p>
  </div>
<?php include "footer.php" ?>
