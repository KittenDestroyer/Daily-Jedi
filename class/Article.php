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

  public static function getByIden( $id ) {
    $conn = new Database();
    $conn->query("SELECT *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM articlesen WHERE id = :id");
    $conn->bind( ":id", $id );
    $conn->execute();
    $row = $conn->singleFetched();
    $conn = null;
    if ( $row ) return new Article( $row );
  }

  public static function getByIdua( $id ) {
    $conn = new Database();
    $conn->query("SELECT *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM articlesua WHERE id = :id");
    $conn->bind( ":id", $id );
    $conn->execute();
    $row = $conn->singleFetched();
    $conn = null;
    if ( $row ) return new Article( $row );
  }

  public static function getListen( $page, $numRows=1000000, $order="pubDate DESC" ) {
    $conn = new Database();
    $conn->query("SELECT *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM articlesen
            ORDER BY " . $order . " LIMIT :page, :numRows");
    $conn->bind( ":numRows", $numRows );
    $conn->bind( ":page", $page );
    $conn->execute();
    $list = array();

    $row = $conn->allFetched();
    foreach ( $row as $article )
    {
      $article = new Article($article);
      $list[] = $article;
    }
    $totalRows = $conn->rowCount();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows ) ); 
  }

  public static function getListua( $page, $numRows=1000000, $order="pubDate DESC" ) {
    $conn = new Database();
    $conn->query("SELECT *, UNIX_TIMESTAMP(pubDate) AS pubDate FROM articlesua
            ORDER BY " . $order . " LIMIT :page, :numRows");
    $conn->bind( ":numRows", $numRows );
    $conn->bind( ":page", $page );
    $conn->execute();
    $list = array();

    $row = $conn->allFetched();
    foreach ( $row as $article )
    {
      $article = new Article($article);
      $list[] = $article;
    }
    $totalRows = $conn->rowCount();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows ) ); 
  }

  public function inserten() {
    if ( !is_null( $this->id ) ) trigger_error ( "Article with such id is already exists.", E_USER_ERROR );
    $conn = new Database();
    $conn->beginTransaction();
    $conn->query("INSERT INTO articlesen ( pubDate, title, content ) VALUES ( FROM_UNIXTIME(:pubDate), :title, :content )");
    $conn->bind( ":pubDate", $this->pubDate );
    $conn->bind( ":title", $this->title );
    $conn->bind( ":content", $this->content );
    $conn->endTransaction();
    $conn->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }

  public function insertua() {
    if ( !is_null( $this->id ) ) trigger_error ( "Article with such id is already exists.", E_USER_ERROR );
    $conn = new Database();
    $conn->beginTransaction();
    $conn->query("INSERT INTO articlesua ( pubDate, title, content ) VALUES ( FROM_UNIXTIME(:pubDate), :title, :content )");
    $conn->bind( ":pubDate", $this->pubDate );
    $conn->bind( ":title", $this->title );
    $conn->bind( ":content", $this->content );
    $conn->endTransaction();
    $conn->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }

  public function updateen() {
    if ( is_null( $this->id ) ) trigger_error ( "There is no article with such id.", E_USER_ERROR );
    $conn = new Database();
    $conn->beginTransaction();
    $conn->query("UPDATE articlesen SET pubDate=FROM_UNIXTIME(:pubDate), title=:title, content=:content WHERE id = :id");
    $conn->bind( ":pubDate", $this->pubDate );
    $conn->bind( ":title", $this->title );
    $conn->bind( ":content", $this->content );
    $conn->bind( ":id", $this->id );
    $conn->endTransaction();
    $conn->execute();
    $conn = null;
  }

  public function updateua() {
    if ( is_null( $this->id ) ) trigger_error ( "There is no article with such id.", E_USER_ERROR );
    $conn = new Database();
    $conn->beginTransaction();
    $conn->query("UPDATE articlesua SET pubDate=FROM_UNIXTIME(:pubDate), title=:title, content=:content WHERE id = :id");
    $conn->bind( ":pubDate", $this->pubDate );
    $conn->bind( ":title", $this->title );
    $conn->bind( ":content", $this->content );
    $conn->bind( ":id", $this->id );
    $conn->endTransaction();
    $conn->execute();
    $conn = null;
  }

  public function deleteen() {
    if ( is_null( $this->id ) ) trigger_error ( "There is no article with such id.", E_USER_ERROR );
    $conn = new Database();
    $conn->query("DELETE FROM articlesen WHERE id = :id LIMIT 1");
    $conn->bind( ":id", $this->id );
    $conn->execute();
    $conn - null;
  }

  public function deleteua() {
    if ( is_null( $this->id ) ) trigger_error ( "There is no article with such id.", E_USER_ERROR );
    $conn = new Database();
    $conn->query("DELETE FROM articlesua WHERE id = :id LIMIT 1");
    $conn->bind( ":id", $this->id );
    $conn->execute();
    $conn - null;
  }


}

?>