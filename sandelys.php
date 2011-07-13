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


<script type="text/javascript" src="js/globalFunc.js"/>
<script type="text/javascript" src="js/mngSandelys.js"/>


<button id="btn-WH-AddWareProd" class="btnPlus" style="display: block;float:left">Naujas sandėlio produktas</button>
<button id="btn-WH-RemWareProd" class="btnMinus"style="display: block;float:left">Pašalinti sandėlio produktą</button>
<input type="submit" id="btn-WH-NewProdDlg" value="Produktas" style="display: block;float:right"/>
<TABLE id="tblWarehouse" summary="Sandelio produktu sarašas" class="Prod" cellspacing="0">
<?php echo $valgykla->listWarehouseProduct(); ?>
</TABLE>
<div class="wildCard" title="Produkto galiojimas pasibaigęs" style="background-color: #FF245A"></div>
<div class="wildCard" title="Produkto galiojimas baigsis už dienos" style="background-color: #FC7798"></div>
<div class="wildCard" title="Produkto galiojimas baigsis už 3 dienų" style="background-color: #FFC4D3"></div>

<button class="btn_print" id="btn-wh-print" style="float:right;">Spausdinti</button>
<span style="display:block;clear:both"></span>

<div id="dlg-WH-NewProd">
  <table class="formT">
    <tr>
      <td colspan="2" style="text-align:center">Produkto šalinimas</td>
    </tr>
    <tr>
      <td>Produktai</td>
      <td><?php echo $valgykla->listProductAlt("lst-wh-Prod-list"); ?></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" id="btn-WH-RemProd" value="Šalinti" /></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align:center">Naujo produkto registracija</td>
    </tr>
    <tr>
      <td><label for="in-WH-ProdName">Produkto pav.</label></td>
      <td><input type="text" id="in-WH-ProdName"/></td>
    </tr>
    <tr>
      <td><label for="lst-WH-Units">Matavimo vnt.</label></td>
      <td><?php echo $valgykla->listUnit("lst-WH-Units"); ?></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" id="btn-WH-NewProd" value="Pridėti" /></td>
    </tr>
  </table>
</div>

<div id="dlg-WH-NewSandProd">
  <table class="formT">
    <tr>
      <td valign="top"><label for="lst-WH-Prod">Produktas</label></td>
      <td> <?php echo $valgykla->listProductAlt("lst-WH-Prod"); ?></td>
    </tr>
    <tr>
      <td><label for="in-WH-Count">Kiekis</label></td>
      <td><input type="text" value="0" id="in-WH-Count"/></td>
    </tr>
    <tr>
      <td><label for="in-WH-ValidDate">Galiojimo data</label></td>
      <td><input type="text" value="2011-05-23" id="in-WH-ValidDate"></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" id="btn-WH-AddProd" value="Prideti" /><input type="submit" id="btn-wh-close-prod-dlg" value="Uždaryti" /></td>
    </tr>
  </table>
</div>
