<script type="text/javascript" src="js/mngAtsijungimas.js"></script>
<?php
session_start();
session_destroy();
session_unset("session");
?>
<p>Jūs atsijungėte nuo sistemos.</p>