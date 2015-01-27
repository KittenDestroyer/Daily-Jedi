<?php include "header.php"; ?>
  <div id="lightSide">
  <a href="test.php">Test</a>
  <div class="content">
    <dl>
<?php foreach( $results["article"] as $article ) { ?>
  <h2>
    <dt><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>"><?php echo htmlspecialchars( $article->title )?></a></dt>
      <dd class="sampleContent"><?php echo cut($article->content, 150); ?><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>">...</a></dd>
      <dd class="pubDate"><?php echo date('j F', $article->pubDate ) ?></dd>
  </h2>
<?php } ?>
    </dl>
<?php 
  if ( $page > 1 ) {
  echo '<a href="?page='.($page - 1).'">Previous</a>';
}
  if ( $page < $totalPages ) {
  echo '<a href="?page='.($page + 1).'">Next</a>';
}
?> 
  </div>
    <p><a href="./?action=archive">Jedi archive</a></p>
  </div>
<?php include "footer.php"; ?>