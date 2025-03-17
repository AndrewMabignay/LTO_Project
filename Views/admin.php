<?php 
    session_start();
    echo $_SESSION['id'] . $_SESSION['name'] . $_SESSION['age'] . $_SESSION['address'] . $_SESSION['password'] . $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a href="admin/accounts.php">User Accounts</a>
        <a href="admin/registered.php">Registration</a>
    </div>
</body>
</html>