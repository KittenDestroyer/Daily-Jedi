<?php include ( "header.php" ); ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username'] ) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p><br>
  </div>
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage']; ?></div>
<?php } ?>
<?php if ( isset( $results['statusMessage'] ) ) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage']; ?></div>
<?php } ?>
  <div id="articleList">
    <p><a href="admin.php?action=newArticle">Add a New Article</a></p>
    <table>
      <tr>
        <th>Publication Date</th>
        <th>Article</th>
      </tr>
<?php foreach ( $results['articles'] as $article) { ?>
      <tr>
        <td><?php echo date('j M Y', $article->pubDate)?></td>
        <td>
          <a href="admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>"><?php echo $article->title ?></a>
        </td>
      </tr>
<?php } ?>
    </table>
    <p id="totalRows"><?php echo $results['totalRows']?> article<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
<?php 
  if ( $page > 1 ) {
  echo '<a href="?page='.($page - 1).'">Previous</a>';
}
  if ( $page < $totalPages ) {
  echo '<a href="?page='.($page + 1).'">Next</a>';
}
?> 
  </div>
  <a href="admin.php?action=listUsers">View Padawans</a>
  <a href="admin.php?action=listArticles">View Articles</a>
  </div>
<?php include('footer.php'); ?>