<?php 
    session_start();

    echo $_SESSION['id'];

    if (!isset($_SESSION['id'])):
        header("Location: ../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "User"):
        header("Location: admin.php");
        exit;
    endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello User!</h1>
</body>
</html>