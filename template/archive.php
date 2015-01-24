<?php include "header.php"; ?>
  <div id="lightSide">
    <dl class="content">
<?php foreach ( $results['article'] as $article ) { ?>
  <h2>
    <dt><span class="pubDate"><?php echo date('j F Y', $article->pubDate) ?></span></dt>
    <dd><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>"><?php echo htmlspecialchars( $article->title )?></a></dd>
  </h2>
<?php } ?>
    </dl>
    <p id="totalRows"><?php echo $results['totalRows']?> article<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
  </div>
<?php include "footer.php"; ?>