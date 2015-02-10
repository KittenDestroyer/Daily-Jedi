<?php
class Image {

  public $user_id;
  public $imagepath;

  public function __construct($data = array()) {
  	if (isset($data['user_id'])) $this->user_id = $data['user_id'];
  	if (isset($data['imagepath'])) $this->imagepath = $data['imagepath'];
  }

  public function storeForm($params) {
  	$this->__construct($params);
  }

  public function insert($user_id, $imagepath) {
    $conn = new Database();
    $conn->query("INSERT INTO images (user_id, imagepath) VALUES (:user_id, :imagepath)");
    $conn->bind(":user_id", $user_id);
    $conn->bind(":imagepath", $imagepath);
    $conn->execute();
    $conn = null;
  }

  public function update( $user_id, $imagepath ) {
    $conn = new Database();
    $conn->query("UPDATE images SET imagepath = :imagepath WHERE user_id = :user_id");
    $conn->bind(":user_id", $user_id);
    $conn->bind(":imagepath", $imagepath);
    $conn->execute();
    $conn = null;
    }

  public static function getImage($id) {
  	$conn = new Database();
  	$conn->query("SELECT * FROM images WHERE user_id = :id");
  	$conn->bind(":id", $id);
  	$conn->execute();
    $row = $conn->singleFetched();
    $conn = null;
    return $row['imagepath'];
  }
}
?>