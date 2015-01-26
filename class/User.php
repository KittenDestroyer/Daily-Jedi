<?php
  class User
  {
  	private $userRoles = array();

  	public function __construct($user_id)
  	{
  		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
  		$sql = "SELECT * FROM user WHERE user_id = :user_id";
  		$st = $conn->prepare( $sql );
  		$st->bindValue( ":user_id", $user_id, PDO::PARAM_STR );
  		$st->execute();

  		if($st->rowCount() == 1)
  		{
  			$userData = $st->fetch( PDO::FETCH_ASSOC );
  			$this->user_id = $user_id;
  			$this->username = ucfirst( $userData['username'] );
  			$this->email = $userData['email'];
  			self::loadRoles();
  		}
  	}

  	public static function loadRoles()
  	{
  		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  		$sql = "SELECT user_role.role_id, role.role_name FROM user_role JOIN role
  		ON user_role.role_id = role.role_id WHERE user_role.user_id = :user_id";
  		$st = $conn->prepare( $sql );
  		$st->bindValue( ":user_id", $this->user_id, PDO::PARAM_STR );
  		$st->execute();

  		while($row = $st->fetch( PDO::FETCH_ASSOC ) )
  		{
  			$this->userRoles[$row["role_name"]] = Role::getRole($row["role_id"]);
  		}
  	}

  	public function hasPermission($permission)
  	{
  		foreach( $this->userRoles as $role )
  		{
  			if( $role->hasPermission($permission) )
  			{
  				return true;
  			}
  		}
  		return false;
  	}
  }