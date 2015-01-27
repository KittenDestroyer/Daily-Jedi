<?php
  class Database
  {
  	private $dsn = DB_DSN;
  	private $user = DB_USERNAME;
  	private $pass = DB_PASSWORD;

  	private $dbh;
  	private $error;
  	private $stmt;

  	public function __construct()
  	{
  		$options = array(
  			PDO::ATTR_PERSISTENT => true,
  			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  		);

  		try
  		{
  			$this->dbh = new PDO( $this->dsn, $this->user, $this->pass, $options );
  		}
  		catch(PDOException $e)
  		{
  			$this->error = $e->getMessage();
  		}
  	}

  	public function query($query)
  	{
  		$this->stmt = $this->dbh->prepare($query);
  	}

  	public function bind( $param, $value, $type = null )
  	{
  		111
  	}
  }