<?php 
session_start();

$_SESSION[] = "";
session_unset();
session_destroy();

setcookie("cookie_id", "", time() - 3600 );
setcookie("cookie_key", "", time() - 3600 );

header("Location: login.php")
?>