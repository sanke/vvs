<?php

require_once('functions.php');
require_once('session.php');

// Ganama valgyklos klasės instancija
$_ValgyklaDB = ValgyklaDB::getInstance();
$_ValgyklaDB->initDB('localhost', 'valgykla', 'ponas', 'valgykla_db');


// Filtruojamas $post masyvas tam, kad išfiltruoti netinkamus duomenis
$post = array_map("filter_POST_GET", $_POST);


// Ganamas $ID - nurodo funkcija, kuri bus vykdoma
if (isset($post['ID']))
  $ID = $post['ID'];
else
  exit('Kritine klaida.');

if ($ID == 15)
  login($post['var0'], $post['var1']);
else if (!hasSession())
  exit('Turite prisijungti');
else if (!$_SESSION['session']->loggedIn)
  exit('Turite prisijungti');
// Level
// 2 - Vadybininkas
// 1 - Virejas
// Access
// 
// Priklausomai nuo $ID yra parenkama atitinkama funkcija, bei perduodami atitinkami parametrai
switch ($ID) {
  case 1:
    if (canUseFunction(2)) {
      $_ValgyklaDB->addUser($post['var0'], $post['var1'], $post['var2'], $post['var3'], $post['var4']);
    }
    break;
  case 2:
    if (canUseFunction(1)) {
      $_ValgyklaDB->addProduct($post['var0'], $post['var1']);
    }
    break;
  case 3:
    if (canUseFunction(1)) {
      $_ValgyklaDB->updateProduct($post['var0'], $post['var1']);
    }
    break;
  case 4:
    if (canUseFunction(1)) {
      $_ValgyklaDB->removeProduct($post['var0']);
    }
    break;
  case 5:
    if (canUseFunction(2)) {
      $_ValgyklaDB->removeUser($post['var0']);
    }
    break;
  case 6:
    if (canUseFunction(1)) {
      $_ValgyklaDB->addDish($post['var0']);
    }
    break;
  case 7:
    if (canUseFunction(1)) {
      $_ValgyklaDB->removeDish($post['var0']);
    }
    break;
  case 8:
    if (canUseFunction(1)) {
      $_ValgyklaDB->addDishProduct($post['var0'], $post['var1'], $post['var2']);
    }
    break;
  case 9:
    if (canUseFunction(1)) {
      $_ValgyklaDB->listDishProductTable($post['var0']);
    }
    break;
  case 10:
    if (canUseFunction(1)) {
      $_ValgyklaDB->removeDishProduct($post['var0'], $post['var1']);
    }
    break;
  case 11:
    if (canUseFunction(1)) {
      $_ValgyklaDB->addWarehouseProduct($post['var0'], $post['var1']);
    }
    break;
  case 12:
    if (canUseFunction(1)) {
      $_ValgyklaDB->addProduction($post['var0'], $post['var1'], $post['var2'], $post['var3']);
    }
    break;
  case 13:
    if (canUseFunction(1)) {
      $_ValgyklaDB->listProductionAlt($post['var0']);
    }
    break;
  case 14:
    if (canUseFunction(1)) {
      $_ValgyklaDB->listProduction();
    }
    break;
  case 15:
    //login($post['var0'], $post['var1']);
    break;
  case 16:
    if (canUseFunction(1)) {
      $_ValgyklaDB->removeWarehouseProduct($post['var0']);
    }
    break;
  case 17:
    if (canUseFunction(1)) {
      $_ValgyklaDB->addWarehouseProductAlt($post['var0'], $post['var1'], $post['var2']);
    }
    break;
  case 18:
    if (canUseFunction(1)) {
      $_ValgyklaDB->listDishProductTable($post['var0']);
    }
    break;
  case 19:
    if (canUseFunction(1)) {
      $_ValgyklaDB->removeProduction($post['var0']);
    }
    break;
  case 20:
    if (canUseFunction(1)) {
      $_ValgyklaDB->listConsumedProductsTable("tbl-consumed-title", $post['var0']);
    }
    break;
  case 21:
    if (canUseFunction(1)) {
      $_ValgyklaDB->listConsumedProductsTable("tbl-consumed-title");
    }
    break;
}
?>