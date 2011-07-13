<?php
// patiekalai.php
require_once('include/functions.php');
require_once('include/session.php');
require_once('include/sessionCheck.php');

$valgykla = ValgyklaDB::getInstance();
$valgykla->initDB('localhost', 'valgykla', 'ponas', 'valgykla_db');
?>

<script type="text/javascript" src="js/globalFunc.js"></script>
<script type="text/javascript" src="js/mngPatiekala.js"></script>


<div id="dlg-Dish-Prod">
  <TABLE class="formT">
    <tr><td colspan="2" style="text-align:center">Naujas patiekalo produktas</td></tr>
    <tr>
      <td><label for="lst-Dish-Prod">Produktas</label></td>
      <td><?php echo $valgykla->listProductAlt(false, "lst-Dish-Prod"); ?></td>
    </tr>
    <tr>
      <td><label for="in-Dish-Count">Kiekis</label></td>
      <td><input type="text" id="in-Dish-Count" value="1" STYLE="width: 30px; text-align:center"/></td>
    </tr>
    <tr>
      <td></td>
      <td>
        <button id="btn-Dish-AddProd">Patvirtinti</button><button id="btn-dish-close-dlg">Uždaryti</button>
      </td>
    </tr>
  </TABLE>
</div>

<div id="dlg-Dish-New-Dish">
  <TABLE class="formT">
    <tr>
      <td><label for="in-Dish-Dish">Pavadinimas</label></td>
      <td><input type="text" id="in-Dish-Dish"/></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" id="btn-Dish-AddDish" value="Registruoti" /></td>
    </tr>
  </TABLE>
</div>


<div style="float:right">
  <label for="lst-Dish-Dish">Patiekalas</label>
  <?php echo $valgykla->listDishes("lst-Dish-Dish"); ?>
  <input type="submit" id="btn-Dish-dlg" value="Naujas patiekalas" />
  <input type="submit" id="btn-Dish-RemDish" value="Pašalinti patiekalą" />
</div>

<button id="btn-Dish-NewProdDlg" class="btnPlus">Naujas patiekalo produktas</button>
<button id="btn-Dish-RemProd" class="btnMinus">Pašalinti patiekalo produktą</button>

<!--
  <td><label for="in-Dish-Dish">Patiekalo pav.</label></td>
  <td><input type="text" id="in-Dish-Dish"/></td>
  </tr>
  <tr>
  <td></td>
  <td><input type="submit" id="btn-Dish-AddDish" value="Registruoti" />
  <input type="submit" id="btn-Dish-NewProdDlg" value="Patiekalo produktai" /></td>
  </tr>
</table>
-->
<table class="Prod" id="tbl-dish-prod">
  <?php $valgykla->listDishProductTable(); ?>
</table>
<button class="btn_print" id="btn-ppd-print" style="float:right;">Spausdinti</button>
<span style="display:block;clear:both"></span>
