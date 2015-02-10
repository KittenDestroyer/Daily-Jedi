<?php  include ("header.php"); ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php  echo $globals['YOU_ARE_LOGGED']  ?> <b><a href="admin.php?action=editUser&amp;userId=<?php  echo htmlspecialchars( $_SESSION['id'] )  ?>"><?php  echo htmlspecialchars( $_SESSION['username'] )  ?></a></b>. <a href="admin.php?action=logout"?><?php  echo $globals['LOGOUT']  ?></a></p><br>
    <p id="avatar"><img src="<?php  echo $_SESSION['image']  ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
<?php  if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php  echo $results['errorMessage']; ?></div>
<?php  } ?>
<?php  if ( isset( $results['statusMessage'] ) ) { ?>
  <div class="statusMessage"><?php  echo $results['statusMessage']; ?></div>
<?php  } ?>
<div id="navigation">
<?php  if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator" ) { ?>
    <p><a href="admin.php?action=editSite"><?php  echo $globals['EDIT_SITE']  ?></a></p>
    <p><a href="admin.php?action=newArticle"><?php  echo $globals['NEW_PUB']  ?></a></p>
<?php  } ?>
    <p><a href="admin.php?action=listUsers"><?php  echo $globals['PADAWANS']  ?></a></p>
    <p><a href="admin.php?action=listArticles"><?php  echo $globals['ARTICLES']  ?></a></p>
</div>
    <table>
      <tr>
        <th><?php  echo $globals['PUBDATE']  ?></th>
        <th><?php  echo $globals['ARTICLE']  ?></th>
      </tr>
<?php  foreach ( $results['articles'] as $article) { ?>
      <tr>
        <td><?php  echo date('j M Y', $article->pubDate) ?></td>
        <td>
<?php  if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator" ) { ?>
<?php  if($_SESSION['lang'] == "ua") { ?>
          <a href="admin.php?action=editArticle&amp;articleId=<?php  echo $article->id ?>"><?php  echo $article->title_ua  ?></a>
<?php  } else { ?>
          <a href="admin.php?action=editArticle&amp;articleId=<?php  echo $article->id ?>"><?php  echo $article->title  ?></a>
<?php  } ?>
<?php  } else { ?>
<?php  if($_SESSION['lang'] == "ua") { ?>
          <a href="admin.php?action=viewArticle&amp;articleId=<?php  echo $article->id ?>"><?php  echo $article->title_ua  ?></a>
<?php  } else { ?>
          <a href="admin.php?action=viewArticle&amp;articleId=<?php  echo $article->id ?>"><?php  echo $article->title  ?></a>
<?php  } ?>
<?php  } ?>
        </td>
      </tr>
<?php  } ?>
    </table>
    <p id="totalRows"><?php  echo $results['totalRows'];echo $globals['ARTICLE_TOTAL'] ?></p>
<?php 
    
    if ( $page > 1 ) {
        echo '<a href="?page='.($page - 1).'">Previous</a>';
    }

    
    if ( $page < $totalPages ) {
        echo '<a href="?page='.($page + 1).'">Next</a>';
    }

    ?> 
  </div>
<?php  include('footer.php'); ?>