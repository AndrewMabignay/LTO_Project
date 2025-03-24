<?php

require '../../config.php';

session_start();

if (!isset($_SESSION['id'])):
    header("Location: ../../Auth/login.php");
    exit;
elseif ($_SESSION['role'] !== "Admin"):
    header("Location: ../user.php");
    exit;
endif;    

$id = base64_decode($_GET['id']);

$result = mysqli_query($conn, "DELETE FROM accounts WHERE id=$id");
header("Location:accounts.php");