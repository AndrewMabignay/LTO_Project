<?php

require_once '../config.php';

session_start();

if (isset($_SESSION['id'])) {
    echo $_SESSION['name'];
    echo $_SESSION['role'];
    
    switch ($_SESSION['role']) {
        case "Admin":
            header("Location: ../Views/admin.php");
            break;
        case "User":
            header("Location: ../Views/user.php");
            break;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // echo $username . $password;
    if (empty($username) || empty($password)) {
        echo "Please enter both username and password!";
        exit();
    }

    $query = "SELECT * FROM accounts WHERE Name = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();

    echo $result->num_rows;

    if ($result->num_rows > 0) {
        $users = $result->fetch_assoc();
        
        if ($password === $users['Password']) {
            $_SESSION['id'] = $users['ID'];
            $_SESSION['name'] = $users['Name'];
            $_SESSION['age'] = $users['Age'];
            $_SESSION['address'] = $users['Address'];
            $_SESSION['password'] = $users['Password'];
            $_SESSION['role'] = $users['Role'];


            if ($_SESSION['role'] === 'Admin') {
                header("Location: ../Views/admin.php");
            } else if ($_SESSION['role'] === 'User') {
                header("Location: ../Views/user.php");
            }
            exit();
        } else {
            echo "Incorrect password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LTO Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }


        /* Balanced Darker LTO-Themed Gradient */
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #2C4A9A, #C62828); /* Darker Blue & Red */
            animation: fadeIn 1s ease-in-out;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* Refined Glassmorphism */
        .login-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 30px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 320px;
            color: white;
            border-top: 3px solid rgba(255, 255, 255, 0.3);
        }


        h2 {
            margin-bottom: 20px;
            font-weight: bold;
        }


        label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
        }


        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.25);
            color: white;
            transition: 0.3s;
        }


        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }


        input:focus {
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.35);
        }


        button {
            width: 100%;
            padding: 10px;
            background: white;
            color: #2C4A9A; /* Darker Blue */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }


        button:hover {
            background: #C62828; /* Darker Red */
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>LTO Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>


            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>


            <button type="submit">LOGIN</button>
        </form>
    </div>
</body>
</html>
