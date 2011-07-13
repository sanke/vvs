<?php
/**
 *
 *
 */
require_once('include/functions.php');
require_once('include/session.php');
require_once('include/sessioncheck.php');

$valgykla = ValgyklaDB::getInstance();
$valgykla->initDB('localhost', 'valgykla', 'ponas', 'valgykla_db');
?>

<script type="text/javascript" src="js/globalFunc.js"/>
<script type="text/javascript" src="js/mngGamyba.js"/>

<button id="btn-prod-new-prod-dlg" class="btnPlus" style="display: block;float:left">Naujas įrašas</button>
<button id="btn-prod-rem-prod" class="btnMinus" style="display: block;float:left">Pašalinti įrašą</button>

<div style="float:right">
  <label for="in-prod-date-filter">Filtruoti pagal datą:</label>
  <input type="text" value="2011-05-23" id="in-prod-date-filter">
  <input type="submit" value="Rodyti visus" id="btn-prod-showall">
</div>
<table id="tbl-prod-list" summary="Gamybos ataskaita" class="Prod" cellspacing="0">
<?php echo $valgykla->listProduction(); ?>
</table>


<button id="btn-prod-print" class="btn_print" style="float:right">Spausdinti</button>
<span style="display:block;clear:both"></span>
<div id="dlg-prod-new-prod">
  <table class="formT">
    <tr>
      <td>Virėjas</td>
      <td><?php echo $valgykla->listUserComboBox("lst-prod-cooks"); ?></td>
    </tr>
    <tr>
      <td>Patiekalas</td>
      <td><?php echo $valgykla->listDishes("lst-prod-dishes"); ?></td>
    </tr>
    <tr>
      <td>Kiekis(porc.)</td>
      <td><input type="text" value="0" id="in-prod-count"/></td>
    </tr>
    <tr>
      <td>Data</td>
      <td><input type="text" value="2011-05-23" id="in-prod-date-pick"/></td>
    </tr>
    <tr>
      <td></td>
      <td align="left"><input type="submit" value="Patvirtinti" id="btn-prod-add-prod" /></td>
    </tr>
  </table>
</div>
