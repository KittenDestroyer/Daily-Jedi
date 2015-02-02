<?php include('header.php') ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php echo YOU_ARE_LOGGED ?> <b><?php echo htmlspecialchars( $_SESSION['username'] ) ?></b>. <a href="admin.php?action=logout"><?php echo LOGOUT ?></a></p>
    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
    <form action="admin.php?action=<?php echo $results['formAction'] ?>" method ="post">
      <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
    <dl>
      <dt><label for="title">Article title</label></dt>
        <dd><input type="text" id="title" name="title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->title)?>" /></dd>
      <dt><label for="content">Article content</label></dt>
        <dd><textarea name="content" id="content" placeholder="Content of the article" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['article']->content) ?></textarea></dd>
      <dt><label for="pubDate">Publication Date</label></dt>
        <dd><input type="date" name="pubDate" id="pubDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['article']->pubDate ? date('Y-m-d', $results['article']->pubDate) : "" ?>" /></dd>
    </dl>
  <div>
      <input class="button" type="submit" name="saveChanges" value="<?php echo SAVECHANGES ?>" />
      <input class="button" type="submit" formnovalidate name="cancel" value="<?php echo CANCEL ?>" />
  </div>
    </form>
<?php if ( $results['article']->id ) { ?>
    <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Delete this article?')"><?php echo DELETE ?></a></p>
<?php } ?>
  </div>
<?php include("footer.php"); ?>