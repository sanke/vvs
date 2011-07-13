<?php

if (hasSession()) {
  if (!$_SESSION['session']->loggedIn)
    die("Turite prisijungti");
}
else
  die("Turite prisijungti prie sistemos.");
?>

