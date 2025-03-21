<?php

require '../../config.php';
echo 'Hello World!';

$id = base64_decode($_GET['id']);

$result = mysqli_query($conn, "DELETE FROM accounts WHERE id=$id");
header("Location:accounts.php");