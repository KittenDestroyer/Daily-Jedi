<?php
class Vote {
	private $id;
	private $articleId;
	private $rating;
	private $user_id;

	public function __construct( $data = array() ) {
		if ( isset ( $data['id'] ) ) $this->id = $data['id'];
		if ( isset ( $data['articleId'] ) ) $this->articleId = $data['articleId'];
		if ( isset ( $data['rating'] ) ) $this->rating = $data['rating'];
		if ( isset ( $data['user_id'] ) ) $this->user_id = $data['user_id'];
	}

	public function storeForm( $params ) {
		$this->__construct( $params );
	}

	public static function getRating($user_id, $articleId) {
		$conn = new Database();
		$conn->query("SELECT rating FROM rating WHERE user_id = :user_id AND articleId = :articleId");
		$conn->bind(":user_id", $user_id);
		$conn->bind(":articleId", $articleId);
		$conn->execute();
		$row = $conn->singleFetched();
        $conn = null;
        return $row['rating'];
        //if ( $row ) return new Vote( $row );
	}

	public static function userVote($user_id, $articleId) {
		$conn = new Database();
		$conn->query("SELECT * FROM rating WHERE user_id = :user_id AND articleId = :articleId");
		$conn->bind(":user_id", $user_id);
		$conn->bind(":articleId", $articleId);
		$conn->execute();
		$row = $conn->singleFetched();
        $conn = null;
        //return $row['rating'];
        if ( $row ) return new Vote( $row );
	}

	public static function allVotes($articleId) {
		$conn = new Database();
		$conn->query("SELECT * FROM rating WHERE articleId = :articleId");
		$conn->bind(":articleId", $articleId);
		$conn->execute();
		$total = $conn->rowCount();
	    $row = $conn->allFetched();
	    $list = array();
		
		foreach ($row as $k => $subArray) {
		  foreach ($subArray as $id => $value) {
		    $list[$id] += $value;
		  }
		}
        return array( "rating" => $list['rating'], "total" => $total ); 
	}

	public function insert() {
		$conn = new Database();
		$conn->query("INSERT INTO rating (articleId, rating, user_id) VALUES (:articleId, :rating, :user_id)");
		$conn->bind(":articleId", $this->articleId);
		$conn->bind(":rating", $this->rating);
		$conn->bind(":user_id", $this->user_id);
		$conn->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}

	public function delete() {
		$conn = new Database();
		$conn->query("DELETE FROM rating WHERE id = :id LIMIT 1");
		$conn->bind(":id", $this->id);
		$conn->execute();
		$conn = null;
	}
}
?>