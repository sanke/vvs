<?php
/**
 *
 * @version $Id$
 * @copyright 2010
 */
require_once('include/functions.php');
require_once('include/session.php');
require_once('include/sessionCheck.php');

$valgykla = ValgyklaDB::getInstance();
$valgykla->initDB('localhost', 'valgykla', 'ponas', 'valgykla_db');
?>

<script type="text/javascript" src="js/globalFunc.js"></script>
<script type="text/javascript" src="js/mngVartotoja.js"></script>

<!-- TODO: pakeisti vireju formos elemntu isdeliojima -->

<table class="formT">
  <tr>
    <td><?php echo $valgykla->listUserComboBox("lst-cook-list"); ?></td>
  </tr>
  <tr>
    <td><input type="submit" value="Registruoti" id="btn-cook-NewCookDlg" /><input type="submit" value="Pašalinti" id="btn-cook-RemCook" /></td>
  </tr>
</table>
<div id="dlg-cook-RegCook">
  <table class="formT">
    <tr>
      <td><label for="in-cook-login">Prisijungimo vardas</label></td>
      <td><input type="text" id="in-cook-login"/></td>
    </tr>
    <tr>
      <td><label for="in-cook-pass">Slaptažodis</label></td>
      <td><input type="password" id="in-cook-pass"/></td>
    </tr>
    <tr>
      <td><label for="in-cook-pass-rep">Pakartoti slaptažodį</label></td>
      <td><input type="password" id="in-cook-pass-rep"/></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="in-cook-Name">Vardas</label></td>
      <td><input type="text" id="in-cook-Name"/></td>
    </tr>
    <tr>
      <td><label for="in-cook-Surname">Pavardė</label></td>
      <td><input type="text" id="in-cook-Surname" /></td>
    </tr>
    <tr>
      <td><label for="sel-cook-user-level">Vartotojo pareigos</label></td>
      <td>
        <select id="sel-cook-user-level">
          <option value="2">Vadybininkas</option>
          <option value="1">Virėjas</option>
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Registruoti" id="btn-cook-AddCook" /></td>
    </tr>
  </table>
</div>
