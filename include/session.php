<?php

require_once('database.php');

session_start();

class Session {

  public $time_out = 0;
  public $loggedIn = false;
  public $access_level = 0;

  function __construct() {
    
  }

  function lifeTime() {
    if (!$this->loggedIn)
      return;

    $session_lifetime = 1800;

    $session_life = time() - $this->time_out;

    if ($session_life > $session_lifetime) {
      header("Location: atsijungti.php");
    }

    $this->time_out = time();
  }

}

function hasSession() {
  if (isset($_SESSION['session'])) {
    $_SESSION['session']->lifeTime();
    return true;
  }
  else
    return false;
}

function login($name, $password) {
  $db = Database::getInstance();
  $db->initDB('localhost', 'valgykla', 'ponas', 'valgykla_db');
  $encPassword = md5($password);
  $query = sprintf("SELECT login, slaptazodis, access FROM vartotojai WHERE login='%s' AND slaptazodis='%s'", $name, $encPassword);
  $db->query($query);
  $row = $db->fetchRow();
  if ($row) {
    $_SESSION['session'] = new Session();
    $_SESSION['session']->time_out = time();
    $_SESSION['session']->loggedIn = true;
    $_SESSION['session']->access_level = $row[2];
  } else {
    echo "Neteisingas prisijungimo vardas arba slaptažodis";
    return false;
  }
}

function canUseFunction($requiredLevel) {
  if ($_SESSION['session']->access_level < $requiredLevel)
    return false;
  else
    return true;
}

?>