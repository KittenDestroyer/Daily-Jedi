<?php
  include ( "Database.php" );
  class User
  {
  	private $userRoles = array();

  	public function __construct($user_id)
  	{
  		$conn = new Database();
  		$conn->query("SELECT * FROM user WHERE user_id = :user_id");
  		$conn->bind( ":user_id", $user_id );
  		$conn->execute();

  		if($conn->rowCount() == 1)
  		{
  			$userData = $conn->singleFetch();
  			$this->user_id = $user_id;
  			$this->username = ucfirst( $userData['username'] );
  			$this->email = $userData['email'];
  			self::loadRoles();
  		}
  	}

  	public static function loadRoles()
  	{
  		$conn = new Database();
  		$conn->query("SELECT user_role.role_id, role.role_name FROM user_role JOIN role
  		ON user_role.role_id = role.role_id WHERE user_role.user_id = :user_id");
  		$conn->bind( ":user_id", $this->user_id );
  		$conn->execute();

      $row = $conn->allFetch();

      foreach ( $row["role_name"] as $rname && $row["role_id"] as $rid )
      {
        $this->userRoles[$rname] = Role::getRole($rid);
      }

  		/*while($row = $st->fetch( PDO::FETCH_ASSOC ) )
  		{
  			$this->userRoles[$row["role_name"]] = Role::getRole($row["role_id"]);
  		}*/
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