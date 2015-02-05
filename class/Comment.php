<?php
class Comment {
	public $articleId;
	public $author;
	public $comment;

	public function __construct( $data = array() ) {
		if (isset($data['articleId'] ) ) $this->articleId = $data['articleId'];
		if (isset($data['author'] ) ) $this->author = $data['author'];
		if (isset($data['comment'] ) ) $this->comment = $data['comment'];
	}

	public function storeForm( $params ) {
		$this->__construct($params);
	}

	public static function getList($articleId) {
		$conn = new Database();
		$conn->query("SELECT * FROM comments WHERE articleId=:articleId");
		$conn->bind(":articleId", $articleId);
		$conn->execute();
	    $list = array();

	    $row = $conn->allFetched();
	    foreach ( $row as $comment )
	    {
	      $comment = new Comment($comment);
	      $list[] = $comment;
	    }
	    $conn = null;
	    return ($list);
	}

	public function insert() {
		$conn = new Database();
		$conn->query("INSERT INTO comments (articleId, author, comment) VALUES (:articleId, :author, :comment)");
		$conn->bind(":articleId", $this->articleId);
		$conn->bind(":author", $this->author);
		$conn->bind(":comment", $this->comment);
		$conn->execute();
	}

	public function delete() {
		$conn
	}
}
?>