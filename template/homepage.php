<?php include "header.php"; ?>
  <div id="lightSide">
<?php if (isset( $_SESSION['username'] ) ) { ?>
    <div class="adminHeader">
      <p>You are logged in as <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout">Log out</a></p>
      <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
    </div>
<?php } ?>
<?php if ( isset( $results['statusMessage'] ) ) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage']; ?></div>
<?php } ?>
  <a href="test.php">Test</a>
  <div class="content">
    <dl>
<?php foreach( $results["article"] as $article ) { ?>
  <h2>
    <dt><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>"><?php echo htmlspecialchars( $article->title )?></a></dt>
      <dd class="sampleContent"><?php echo cut($article->content, 150); ?><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">...</a></dd>
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