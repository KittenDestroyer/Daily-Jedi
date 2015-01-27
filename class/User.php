<?php
  include( "Database.php" );
  include( "advanceUser.php" );
  class User
  {
 	/*private $user_id;
 	private $username;
 	private $firstName;
 	private $lastName;
 	private $email;*/

 	private $userData = array();

 	public function __construct( $data = array() )
 	{

 	}

 	public function login( $data )
 	{
 		$conn = new Database();
 		$conn->query( "SELECT * FROM user WHERE username = :username" );
 		$conn->bind( ":username", $data['username'] );
 		$conn->execute();

 		if( $conn->rowCount() == 1 )
 		{
 			$row = $conn->singleFetch();
 			if( $row['password'] == $data['password'] )
 			{
 				$user = new advanceUser( $data['user_id'] );
 				
 			}
 			else
 			{
 				return echo "Incorrect password.";
 			}
 		}
 	}


  }