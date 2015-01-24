<?php
  class Article {

  public $id;
  public $pubDate;
  public $title;
  public $content;

  public function __construct($data = array()) {
    if ( isset( $data['id'] ) ) $this->id = $data['id'];
    if ( isset( $data['pubDate'] ) ) $this->pubDate = $data['pubDate'];
    if ( isset( $data['title'] ) ) $this->title = $data['title'];
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
  }

  public function storeFormValues( $params ) {
    
    $this->__construct( $params );

    if ( isset( $params['pubDate'] ) ) {
      $pubDate = explode ('-', $params['pubDate'] );

      if ( count($pubDate) == 3 ) {
        list ($y, $m, $d ) = $pubDate;
        $this->pubDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM material WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Article( $row );
  }

  public static function getList( $page, $numRows=1000000, $order="pubDate DESC" ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM material
            ORDER BY " . $order . " LIMIT :page, :numRows";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->bindValue( ":page", $page, PDO::PARAM_INT);
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $article = new Article( $row );
      $list[] = $article;
    }

    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) ); 
  }

  public function insert() {
    if ( !is_null( $this->id ) ) trigger_error ( "Article with such id is already exists.", E_USER_ERROR );
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO material ( pubDate, title, content ) VALUES ( FROM_UNIXTIME(:pubDate), :title, :content )";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":pubDate", $this->pubDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_INT );
    $st->bindValue( ":content", $this->content, PDO::PARAM_INT );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }

  public function update() {
    if ( is_null( $this->id ) ) trigger_error ( "There is no article with such id.", E_USER_ERROR );
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE material SET pubDate=FROM_UNIXTIME(:pubDate), title=:title, content=:content WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":pubDate", $this->pubDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

  public function delete() {
    if ( is_null( $this->id ) ) trigger_error ( "There is no article with such id.", E_USER_ERROR );
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "DELETE FROM material WHERE id = :id LIMIT 1";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn - null;
  }


}

?>