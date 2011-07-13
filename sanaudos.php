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
<script type="text/javascript" src="js/mngSanaudos.js"/>

<div style="float:right">
  <label for="in-consumed-filter">Filtruoti pagal datą:</label>
  <input type="text" value="2011-05-23" id="in-consumed-filter">
  <input type="submit" value="Rodyti visus" id="btn-consumed-showall">
</div>
<TABLE id="tbl-consumed-prod" summary="Sunaudotų produktų sąrašas" class="Prod" cellspacing="0">
<?php $valgykla->listConsumedProductsTable("tbl-consumed-title"); ?>
</TABLE>
<button class="btn_print" id="btn-consumed-print" style="float:right;">Spausdinti</button>
<span style="display:block;clear:both"></span>