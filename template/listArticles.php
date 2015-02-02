<?php include ( "header.php" ); ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php echo YOU_ARE_LOGGED ?> <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"?><?php echo LOGOUT ?></a></p><br>
    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage']; ?></div>
<?php } ?>
<?php if ( isset( $results['statusMessage'] ) ) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage']; ?></div>
<?php } ?>
<?php if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator" ) { ?>
    <p><a href="admin.php?action=newArticle"><?php echo NEW_PUB ?></a></p>
<?php } ?>
    <p><a href="admin.php?action=listUsers"><?php echo PADAWANS ?></a></p>
    <p><a href="admin.php?action=listArticles"><?php echo ARTICLES ?></a></p>
    <table>
      <tr>
        <th><?php echo PUBDATE ?></th>
        <th><?php echo ARTICLE ?></th>
      </tr>
<?php foreach ( $results['articles'] as $article) { ?>
      <tr>
        <td><?php echo date('j M Y', $article->pubDate)?></td>
        <td>
<?php if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator" ) { ?>
          <a href="admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>"><?php echo $article->title ?></a>
<?php } else { ?>
          <a href="index.php?action=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo $article->title ?></a>
<?php } ?>
        </td>
      </tr>
<?php } ?>
    </table>
    <p id="totalRows"><?php echo $results['totalRows']; echo ARTICLE_TOTAL?></p>
<?php 
  if ( $page > 1 ) {
  echo '<a href="?page='.($page - 1).'">Previous</a>';
}
  if ( $page < $totalPages ) {
  echo '<a href="?page='.($page + 1).'">Next</a>';
}
?> 
  </div>
<?php include('footer.php'); ?>