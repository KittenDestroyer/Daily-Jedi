<?php
  class Role
  {
  	protected $permissions;

  	protected function __construct()
  	{
  		$this->permissionList = array();
  	}

  	public static function getRole($role_id)
  	{
  		$role = new Role();

  		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  		$sql = "SELECT permission.description FROM role_permission JOIN permissions
  		ON role_permission.permission_id = permission.permission_id WHERE role_permission.role_id = :role_id";
  		$st = $conn->prepare( $sql );
  		$st->bindValue(":role_id", $role_id, PDO::PARAM_INT);
  		$st->execute();

  		while ($row = $st->fetch(PDO::FETCH_ASSOC))
  		{
  			$role->permissionList[$row["permission_description"]] = true;
  		}
  		return $role;
  	}

  	public function verifyPermission($permission)
  	{
  		return isset($this->permissions[$permission]);
  	}
  }