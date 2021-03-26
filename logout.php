<?php

session_start();
unset ($_SESSION['username']);
session_destroy();
echo "Sesión finalizada";
header('refresh:3;index.html');

?>