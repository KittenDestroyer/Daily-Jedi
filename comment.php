<?php

$results = array();
$comment = new Comment;
$comment->storeForm( $_POST );
$comment->insert();
header("Location: index.php?action=viewArticle&articleId=$_POST['articleId']");
?>