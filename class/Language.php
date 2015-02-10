<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Language {

	private $parameter;
	private $value;

	public function __construct($data = array()) {
    if (isset($data['parameter'])) $this->parameter = $data['parameter'];
    if (isset($data['value'])) $this->value = $data['value'];
	}

  public function storeForm($params) {
    $this->__construct($params);
  }

  public function inserten() {
    $conn = new Database();
    $conn->query("INSERT INTO paramsen (parameter, value) VALUES (:parameter, :value)");
    $conn->bind(":parameter", $this->parameter);
    $conn->bind(":value", $this->value);
    $conn->execute();
    $conn = null;
    }

  public function insertua() {
    $conn = new Database();
    $conn->query("INSERT INTO paramsua (parameter, value) VALUES (:parameter, :value)");
    $conn->bind(":parameter", $this->parameter);
    $conn->bind(":value", $this->value);
    $conn->execute();
    $conn = null;
  }

  public function updateen() {
    $conn = new Database();
    $conn->beginTransaction();
    $conn->query("UPDATE paramsen SET value=:value WHERE parameter=:parameter");
    $conn->bind(":value", $this->value);
    $conn->bind(":parameter", $this->parameter);
    $conn->endTransaction();
    $conn->execute();
    $conn = null;
  }

  public function updateua() {
    $conn = new Database();
    $conn->beginTransaction();
    $conn->query("UPDATE paramsua SET value=:value WHERE parameter=:parameter");
    $conn->bind(":value", $this->value);
    $conn->bind(":parameter", $this->parameter);
    $conn->endTransaction();
    $conn->execute();
    $conn = null;
    }

  public static function listParamsen() {
    $conn = new Database();
    $conn->query("SELECT * FROM paramsen");
    $conn->execute();
    $list = array();

    $row = $conn->allFetched();
    foreach ($row as $lang) {
      $lang = new Language($lang);
      $list[$lang->parameter] = $lang->value;
    }
    $conn = null;
    return ($list); 
  }

  public static function listParamsua() {
    $conn = new Database();
    $conn->query("SELECT * FROM paramsua");
    $conn->execute();
    $list = array();

    $row = $conn->allFetched();
    foreach ( $row as $lang ) {
      $lang = new Language($lang);
      $list[$lang->parameter] = $lang->value;
    }
    $conn = null;
    return ($list); 
  }
}
?>