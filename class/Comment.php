<?php
class Comment {
	public $id;
	public $articleId;
	public $author;
	public $topic;
	public $comment;
	public $language;

	public function __construct($data = array()) {

		if (isset($data['id'] ) ) $this->id = $data['id'];
		if (isset($data['articleId'] ) ) $this->articleId = $data['articleId'];
		if (isset($data['author'] ) ) $this->author = $data['author'];
		if (isset($data['topic'] ) ) $this->topic = $data['topic'];
		if (isset($data['comment'] ) ) $this->comment = $data['comment'];
		if (isset($data['language'] ) ) $this->language = $data['language'];
	}

	public function storeForm($params) {
		$this->__construct($params);
	}

	public static function getById($commentId) {
		$conn = new Database();
		$conn->query("SELECT * FROM comments WHERE id = :commentId");
		$conn->bind(":commentId", $commentId);
		$conn->execute();
		$row = $conn->singleFetched();
		$conn = null;
		if ($row) return new Comment($row);
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
		$conn->query("INSERT INTO comments (articleId, author, topic, comment, language) VALUES (:articleId, :author, :topic, :comment, :language)");
		$conn->bind(":articleId", $this->articleId);
		$conn->bind(":author", $this->author);
		$conn->bind(":topic", $this->topic);
		$conn->bind(":comment", $this->comment);
		$conn->bind(":language", $this->language);
		$conn->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}

	public function delete() {
		$conn = new Database();
		$conn->query("DELETE FROM comments WHERE id = :id");
		$conn->bind(":id", $this->id);
		$conn->execute();
		$conn = null;
	}
}
?>