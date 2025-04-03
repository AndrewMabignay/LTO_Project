<?php 
    session_start();

    if (!isset($_SESSION['id'])):
        header("Location: ../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "Admin"):
        header("Location: user.php");
        exit;
    endif;    
    // echo $_SESSION['id'] . $_SESSION['name'] . $_SESSION['age'] . $_SESSION['address'] . $_SESSION['password'] . $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../design/assets/admin.css">
</head>
<body>
    <img class="bg-image" src="../design/assets/img/ltoLogin.png" alt="LTO Background">
    <div class="bg-overlay"></div>

    <div class="container">
        <p>Welcome <?php echo $_SESSION['name'] ?>!</p>
        <a href="admin/accounts.php" class="btn-accounts">User Accounts</a>
        <a href="admin/registered.php" class="btn-registration">Registration</a>
        <a href="../Auth/logout.php" class="btn-logout">Log Out</a>
    </div>   
</body>
</html>