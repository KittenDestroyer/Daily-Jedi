<?php include "header.php" ?>
  <div id="lightSide">
<?php if (isset( $_SESSION['username'] ) ) { ?>
	  <div class="adminHeader">
	    <p><?php echo $globals['YOU_ARE_LOGGED'] ?> <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"><?php echo $globals['LOGOUT'] ?></a></p>
	    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
	  </div>
<?php } ?>
  <div class="content"><?php echo $results['article']->content?></div>
    <h2 id="pubDate">Published on <?php echo date('j F Y', $results['article']->pubDate)?></h2>
  <div id="rating">
    <form action="index.php?action=vote" method="post">
    <dl>
      <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>" />
      <dt><label for="rating">Vote:</label></dt>
      <dd>
        <input type="radio" name="rating" value="1">1<br>
        <input type="radio" name="rating" value="2">2<br>
        <input type="radio" name="rating" value="3">3<br>
        <input type="radio" name="rating" value="4">4<br>
        <input type="radio" name="rating" value="5">5<br>
      </dd>
    </dl>
    <input type="submit" name="saveChanges" value="<?php echo $globals['SAVECHANGES'] ?>" />
    </form>
  </div>
    <div id="comments">
    <dl>
<?php foreach ( $results['comments'] as $comment) { ?>
	<div id="comment">
      <dt>Author:</dt>
        <dd><?php echo $comment->author ?></dd>
      <dt>Comment:</dt>
        <dd><?php echo $comment->comment ?></dd>
    </div>
<?php } ?>
	</dl>
    </div>
<?php if ( isset($_SESSION['role_id']) == "admin" || isset($_SESSION['role_id']) == "moderator" || isset($_SESSION['role_id']) == "user") { ?>
  <div class="commentForm">
    <form action="index.php?action=comment" method="post">
      <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>" />
      <input type="hidden" name="author" value="<?php echo $_SESSION['username'] ?>" />
      <textarea name="comment" placeholder="Place your coment here"></textarea><br>
      <input type="submit" name="saveChanges" value="<?php echo $globals['SAVECHANGES'] ?>" />
    </form>
  </div>
<?php } ?>
    <p><a href="./?action=archive"><?php echo $globals['ARCHIVE'] ?></a></p>
  </div>
<?php include "footer.php" ?>
