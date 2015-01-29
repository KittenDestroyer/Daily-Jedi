<?php
  class User {

  	private $id;
  	private $username;
  	private $email;
    private $password;

  	public function __construct($data = array()) {
  		if ( isset($data['id'] ) ) $this->id = $data['id'];
  		if ( isset($data['username'] ) ) $this->username = $data['username'];
      if ( isset($data['password'] ) ) $this->password = $data['password'];
  		if ( isset($data['email'] ) ) $this->email = $data['email'];
  	}

  	public function storeForm( $params ) {
  		$this->__construct( $params );
  	}

    public function login() {
      $conn = new Database();
      $conn->query("SELECT * FROM user WHERE username = :username");
      $conn->bind( ":username", $this->username );
      $conn->execute();
      $row = $conn->singleFetched();
      if ( $row['password'] == $this->password ) {
        return true;
      } else {
        return false;
      }
    }

  	public static function getUser( $id ) {
      $conn = new Database();
      $conn->query("SELECT * FROM user WHERE id = :id");
      $conn->bind( ":id", $id );
      $conn->execute();
      $row = $conn->singleFetched();
      $conn = null;
      if ( $row ) return new User( $row );
    }

    public static function listUsers() {
      $conn = new Database();
      $conn->query("SELECT * FROM user");
      $conn->execute();
      $list = array();

      $row = $conn->allFetched();
      foreach ( $row as $user )
      {
        $user = new User($user);
        $list[] = $user;
      }
      $totalRows = $conn->rowCount();
      $conn = null;
      return ( array ( "results" => $list, "totalRows" => $totalRows ) ); 
    }

    public function insert() {
      if ( !is_null( $this->id ) ) trigger_error ( "This user already exists.", E_USER_ERROR );
      $conn = new Database();
      $conn->beginTransaction();
      $conn->query("INSERT INTO user ( username, password, email ) VALUES ( :username, :password, :email )");
      $conn->bind( ":username", $this->username );
      $conn->bind( ":password", $this->password );
      $conn->bind( ":email", $this->email );
      $conn->endTransaction();
      $conn->execute();
      $this->id = $conn->lastInsertId();
      $conn = null;
    }

    public function update() {
      if ( is_null( $this->id ) ) trigger_error ( "There is no such user.", E_USER_ERROR );
      $conn = new Database();
      $conn->beginTransaction();
      $conn->query("UPDATE user SET username=:username, password=:password, email=:email WHERE id = :id");
      $conn->bind( ":username", $this->username );
      $conn->bind( ":password", $this->password );
      $conn->bind( ":email", $this->email );
      $conn->bind( ":id", $this->id );
      $conn->endTransaction();
      $conn->execute();
      $conn = null;
    }

    public function delete() {
      if ( is_null( $this->id ) ) trigger_error ( "There is no such user.", E_USER_ERROR );
      $conn = new Database();
      $conn->query("DELETE FROM user WHERE id = :id LIMIT 1");
      $conn->bind( ":id", $this->id );
      $conn->execute();
      $conn - null;
    }

  }
?>