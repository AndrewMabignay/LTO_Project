<?php 
    session_start();

    if (!isset($_SESSION['id'])):
        header("Location: ../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "Admin"):
        header("Location: user.php");
        exit;
    endif;    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            animation: fadeIn 1s ease-in-out;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: slideUp 1s forwards ease-in-out;
            width: 250px;
        }
        a {
            display: block;
            text-decoration: none;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-accounts { background: #3498db; } /* Blue */
        .btn-accounts:hover { background: #2980b9; }
        
        .btn-registration { background: #2ecc71; } /* Green */
        .btn-registration:hover { background: #27ae60; }
        
        .btn-logout { background: #e74c3c; } /* Red */
        .btn-logout:hover { background: #c0392b; }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin/accounts.php" class="btn-accounts">User Accounts</a>
        <a href="admin/registered.php" class="btn-registration">Registration</a>
        <a href="../Auth/logout.php" class="btn-logout">Log Out</a>
    </div>
</body>
</html>