<?php
  include( "Database.php" );
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

  		$conn = new Database();
  		$conn->query("SELECT permission.description FROM role_permission JOIN permissions
  		ON role_permission.permission_id = permission.permission_id WHERE role_permission.role_id = :role_id");
  		$conn->bind(":role_id", $role_id, PDO::PARAM_INT);
  		$conn->execute();

      $row = $conn->allFetched();

      foreach ($row["permission_description"] as $desc )
      {
        $role->permissionList[$desc] = true;
      }
      
  		return $role;
  	}

  	public function verifyPermission($permission)
  	{
  		return isset($this->permissions[$permission]);
  	}
  }