<?php
require_once('include/functions.php');
require_once('include/session.php');

$valgykla = ValgyklaDB::getInstance();
$valgykla->initDB('localhost', 'valgykla', 'ponas', 'valgykla_db');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Valgykla</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/smoothness/jquery-ui-1.8.13.custom.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/jquery.tooltip.css" />
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
    <!--[if IE]>
    <style type="text/css">
    </style>
    <![endif]-->
    <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

    <script src="js/lib/jquery.bgiframe.js" type="text/javascript"></script>

    <script src="js/jquery.tooltip.js" type="text/javascript"></script>
  </head>
  <body>
    <div id="container">
      <div id="tabs">
        <ul>
          <?php
          if (!hasSession()) {
            echo '<li><a href="prisijungimas.php"><span>Prisijungimas</span></a></li>';
          } else if ($_SESSION['session']->loggedIn) {
            if (canUseFunction(1)) {
              echo '<li><a href="patiekalai.php"><span>Patiekalai</span></a></li>';
              echo '<li><a href="sandelys.php"><span>Sandėlys</span></a></li>';
              echo '<li><a href="gamyba.php"><span>Virtuvė</span></a></li>';
              echo '<li><a href="sanaudos.php"><span>Gamybos sąnaudos</span></a></li>';
            }
            if (canUseFunction(2)) {
              echo '<li><a href="vartotojai.php"><span>Vartotojai</span></a></li>';
            }
            echo '<li style="float:right" ><a href="Atsijungti.php"><span>Atsijungti</span></a></li>';
            echo '<li style="float:right" ><a href="#"><span>Nustatymai</span></a></li>';
          }
          ?>
        </ul>
      </div>
      <div id="messages">
      </div>
    </div>

  </body>
</html>