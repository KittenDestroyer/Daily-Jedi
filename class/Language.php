<?php
class Language {

	private $parameter;
	private $value;
	private $table;

	public function __construct( $data = array() ) {
    if ( isset( $data['parameter'] ) ) $this->parameter = $data['parameter'];
    if ( isset( $data['value'] ) ) $this->value = $data['value'];
    if ( isset( $data['table'] ) ) $this->table = $data['table'];
	}

    public function storeForm( $params ) {
      $this->__construct( $params );
    }

    public function updateen() {
      $conn = new Database();
      $conn->beginTransaction();
      $conn->query("UPDATE paramsen SET value=:value WHERE parameter=:parameter");
      //$conn->bind( ":table", $this->table );
      $conn->bind( ":value", $this->value );
      $conn->bind( ":parameter", $this->parameter );
      $conn->endTransaction();
      $conn->execute();
      $conn = null;
    }

    public function updateua() {
      $conn = new Database();
      $conn->beginTransaction();
      $conn->query("UPDATE paramsua SET value=:value WHERE parameter=:parameter");
      //$conn->bind( ":table", $this->table );
      $conn->bind( ":value", $this->value );
      $conn->bind( ":parameter", $this->parameter );
      $conn->endTransaction();
      $conn->execute();
      $conn = null;
    }

    public static function listParamsen() {
      $conn = new Database();
      $conn->query("SELECT * FROM paramsen");
      //$conn->bind( ":table", $table);
      $conn->execute();
      //$list = array();

      $row = $conn->allFetched();
      foreach ( $row as $lang )
      {
      	$lang = new Language($lang);
        $list[$lang->parameter] = $lang->value;
      }
      $conn = null;
      return ($list); 
    }

    public static function listParamsua() {
      $conn = new Database();
      $conn->query("SELECT * FROM paramsua");
      //$conn->bind( ":table", $table);
      $conn->execute();
      //$list = array();

      $row = $conn->allFetched();
      foreach ( $row as $lang )
      {
      	$lang = new Language($lang);
        $list[$lang->parameter] = $lang->value;
      }
      $conn = null;
      return ($list); 
    }
}
?>