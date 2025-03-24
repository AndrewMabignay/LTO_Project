<?php

session_start();

session_unset();
session_destroy();  

header('Location: login.php');
echo "Session has been destroyed.";

?>