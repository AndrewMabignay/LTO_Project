<?php

require_once '../config.php';

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

            if ($users['Role'] === 'Admin') {
                header("Location: ../Views/admin.php");
            } else if ($users['Role'] === 'User') {
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
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="POST">
        <div class="username-container">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>

        <div class="password-container">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit">LOGIN</button>
    </form>
</body>
</html>