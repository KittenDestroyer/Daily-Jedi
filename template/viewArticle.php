<?php  include "header.php"  ?>
  <div id="lightSide">
<?php  if (isset( $_SESSION['username'] ) ) { ?>
    <div class="adminHeader">
      <p><?php  echo $globals['YOU_ARE_LOGGED']  ?> <b><a href="admin.php?action=editUser&amp;userId=<?php  echo htmlspecialchars( $_SESSION['id'] )  ?>"><?php  echo htmlspecialchars( $_SESSION['username'] )  ?></a></b>. <a href="admin.php?action=logout"><?php  echo $globals['LOGOUT']  ?></a></p>
      <p id="avatar"><img src="<?php  echo $_SESSION['image']  ?>" alt="Avatar" height="100" width="100" /></p>
    </div>
<?php  if ( isset( $results['statusMessage'] ) ) { ?>
  <div class="statusMessage"><?php  echo $results['statusMessage']; ?></div>
<?php  } ?>
<?php  } ?>
<?php  if($_SESSION['lang'] == "ua") { ?> 
  <div class="content"><p><?php  echo $results['article']->content_ua ?></p></div>
<?php  } else { ?>
  <div class="content"><p><?php  echo $results['article']->content ?></p></div>
<?php  } ?>
    <h2 id="pubDate">Published on <?php  echo date('j F Y', $results['article']->pubDate) ?></h2>
<?php  if ( isset($_SESSION['role_id']) == "admin" || isset($_SESSION['role_id']) == "moderator" || isset($_SESSION['role_id']) == "user") { ?>
<?php  if ( $userVote == 0) { ?>
  <div id="rating">
    <form action="index.php?action=vote" method="post">
    <dl>
      <input type="hidden" name="articleId" value="<?php  echo $results['article']->id  ?>" />
      <input type="hidden" name="user_id" value="<?php  echo $_SESSION['id']  ?>" />
      <dt><label for="rating">Vote:</label></dt>
      <dd>
        <input type="radio" name="rating" value="1">1<br>
        <input type="radio" name="rating" value="2">2<br>
        <input type="radio" name="rating" value="3">3<br>
        <input type="radio" name="rating" value="4">4<br>
        <input type="radio" name="rating" value="5">5<br>
      </dd>
    </dl>
    <input type="submit" name="saveChanges" value="<?php  echo $globals['SAVECHANGES']  ?>" />
    </form>
<?php  } else { ?>
  <h1>Your rating is <?php  echo $userVote  ?></h1>
  <p><a href="index.php?action=deleteVote&amp;articleId=<?php  echo $results['article']->id  ?>">Delete vote</a></p>
<?php  } ?>
  </div>
<?php  } ?>
<?php  if (!$votes['total'] == 0) { ?>
  <div id="comments">
    <dl>
    <dt>Total votes:</dt>
      <dd><?php  echo $votes['total']  ?></dd>
    <dt>Rating:</dt>
      <dd><?php  echo round($votes['rating'] / $votes['total'], 1)  ?></dd>
    </dl>
  </div>
<?php  } else { ?>
    <h1>No votes</h1>
<?php  } ?>
  <div id="comments">
<?php  foreach ( $results['comments'] as $comment) { ?>
<?php  if($comment->language != $_SESSION['lang']) continue; ?>
  <div id="comment">
      <dt>Author:</dt>
        <dd><?php  echo $comment->author  ?></dd>
      <dt>Topic:</dt>
        <dd><?php  echo $comment->topic  ?></dd>
      <dt>Comment:</dt>
        <dd><?php  echo $comment->comment  ?></dd>
<?php  if ( isset($_SESSION['role_id'] ) == "admin" ) { ?>
  <p><a href="index.php?action=deleteComment&amp;articleId=<?php  echo $results['article']->id  ?>&amp;commentId=<?php  echo $comment->id  ?>" onclick="return confirm('Delete this comment?')">Delete comment</a></p>
<?php  } ?>
    </div>
<?php  } ?>
  </dl>
    </div>
<?php  if ( isset($_SESSION['role_id']) == "admin" || isset($_SESSION['role_id']) == "moderator" || isset($_SESSION['role_id']) == "user") { ?>
  <div class="commentForm">
    <form action="index.php?action=comment" method="post">
      <input type="hidden" name="articleId" value="<?php  echo $results['article']->id  ?>" />
      <input type="hidden" name="author" value="<?php  echo $_SESSION['username']  ?>" />
      <input type="hidden" name="language" value="<?php  echo $_SESSION['lang']  ?>" />
      <input type="text" name="topic" placeholder="Topic" /><br>
      <textarea name="comment" placeholder="Place your coment here"></textarea><br>
      <input type="submit" name="saveChanges" value="<?php  echo $globals['SAVECHANGES']  ?>" />
    </form>
  </div>
<?php  } ?>
<?php  include "footer.php"  ?>