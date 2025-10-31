<?php

$dir = __DIR__;
require_once $dir . '/../../persistence/conf/PersistentManager.php';

abstract class GenericDAO {

  protected $conn = null;
  public function __construct() {
    $this->conn = PersistentManager::getInstance()->get_connection();
  }

  abstract protected function insert($nombre, $password);
  abstract protected function selectAll();
  abstract protected function selectById($id);
  abstract protected function update($id, $nombre, $password);
  abstract protected function delete($id);

}
