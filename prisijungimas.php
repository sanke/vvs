<?php
/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once('include/database.php');
require_once('include/session.php');
?>

<script type="text/javascript" src="js/globalFunc.js"></script>
<script type="text/javascript" src="js/mngPrisijungimas.js"></script>


<table class="formT">
  <tr>
    <td><label for="name" maxlength="16">Vartotojas</label></td>
    <td><input type="text" id="inName" maxlength="16"></td>
  </tr>
  <tr>
    <td><label for="password">Slaptažodis</label></td>
    <td><input type="password" id="inPassword"></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" id="btnLogin" value="Prisijungti"></td>
  </tr>
</table>

