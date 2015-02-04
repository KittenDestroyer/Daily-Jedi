<?php
class Vote {
	private $id;
	private $articleId;
	private $rating;
	private $total;

	public function __construct( $data = array() ) {
		if ( isset ( $data['articleId'] ) ) $this->articleId = $data['articleId'];
		if ( isset ( $data['rating'] ) ) $this->rating = $data['rating'];
		if ( isset ( $data['total'] ) ) $this->total = $data['total'];
	}

	public storeForm( $params ) {
		$this->__construct( $params );
	}

	public function insert() {
		$conn = new Database();
		$conn->query("INSERT INTO  ")
	}
}