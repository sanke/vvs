<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

/**
 * Duomenu bazes klase skirta valdyti MYSQL.
 */
class Database {

  protected $_con = null;
  protected $_result = null;
  private static $_pInstance;

  final public static function getInstance() {
    if (!isset(self::$_pInstance)) {
      self::$_pInstance = new static;
    }

    return self::$_pInstance;
  }

  function initDB($host, $user, $password, $db) {
    $this->_con = mysql_connect($host, $user, $password);
    if (!$this->_con)
      die('Klaida: ' . mysql_error($this->_con));

    mysql_query("SET NAMES 'utf8'");

    if (!mysql_select_db($db, $this->_con))
      die('Klaida: ' . mysql_error($this->_con));
  }

  function __destruct() {
    if ($this->_con)
      mysql_close($this->_con);
  }

  function query($str) {
    $this->_result = mysql_query($str, $this->_con);
    if (!$this->_result) {
      DEBUG_OUT(mysql_error($this->_con));
      die('Klaida: ' . mysql_error($this->_con));
    }
  }

  function fetchRow() {
    if (!$this->_result)
      die('Klaida: Nebuvo atlikta užklausa.');

    return mysql_fetch_array($this->_result);
  }

  function fetchRowRes($res) {
    if (!$this->_result)
      die('Klaida: Nebuvo atlikta užklausa.');

    return mysql_fetch_array($res);
  }

}

?>