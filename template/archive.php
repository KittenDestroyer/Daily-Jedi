<?php  include "header.php"; ?>
  <div id="lightSide">
<?php  if (isset( $_SESSION['username'] ) ) { ?>
    <div class="adminHeader">
      <p>You are logged in as <b><a href="admin.php?action=editUser&amp;userId=<?php  echo htmlspecialchars( $_SESSION['id'] )  ?>"><?php  echo htmlspecialchars( $_SESSION['username'] )  ?></a></b>. <a href="admin.php?action=logout"><?php  echo $globals['LOGOUT']  ?></a></p>
      <p id="avatar"><img src="<?php  echo $_SESSION['image']  ?>" alt="Avatar" height="100" width="100" /></p>
    </div>
<?php  } ?>
    <dl class="content">
<?php  foreach ( $results['article'] as $article ) { ?>
  <h2>
    <dt><span class="pubDate"><?php  echo date('j F Y', $article->pubDate)  ?></span></dt>
    <dd><a href=".?action=viewArticle&amp;articleId=<?php  echo $article->id  ?>"><?php  echo htmlspecialchars( $article->title ) ?></a></dd>
  </h2>
<?php  } ?>
    </dl>
    <p id="totalRows"><?php  echo $results['totalRows'];echo $globals['ARTICLE_TOTAL'] ?></p>
  </div>
<?php  include "footer.php"; ?>