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

$fieldsInvalid = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // echo $username . $password;
    if (empty($username) || empty($password)) {
        $fieldsInvalid = "Please enter both username and password!";
        exit();
    }

    $query = "SELECT * FROM accounts WHERE Name = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();

    // echo $result->num_rows;

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
            $fieldsInvalid = "Incorrect password!";
        }
    } else {
        $fieldsInvalid = "Incorrect Username and Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LTO Portal Login</title>
    
    <link rel="stylesheet" href="../design/assets/login.css">
</head>
<body>
    <img class="bg-image" src="../design/assets/img/ltoLogin.png" alt="LTO Background">
    <div class="bg-overlay"></div>
    
    <div class="container">
        <img src="../design/assets/img/lto_logo.png" alt="LTO Logo" class="lto-logo">
        <h2>LTO Portal Login</h2>
        <form action="login.php" method="POST">
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <p class="error-message"><?php echo $fieldsInvalid == '' ? '' : $fieldsInvalid ?></p>

            <button type="submit">LOGIN</button>
        </form>
    </div>

    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>