<?php

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "INSERT INTO accounts(Name, Age, Address, Password, Role) VALUES ('$name', '$age', '$address', '$password', '$role')";
    $insertFields = \mysqli_query($conn, $query);

    echo $insertFields === true ? header("Location: accounts.php") : 'Not Successfully Inserted!';
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
    <form action="addAccount.php" method="POST">
        <div class="name-container">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </div>

        <div class="name-container">
            <label for="age">Age</label>
            <input type="number" name="age" id="age">
        </div>

        <div class="address-container">
            <label for="address">Address</label>
            <input type="text" name="address" id="address">
        </div>

        <div class="password-container">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="role-container">
            <label for="role">Role : </label>
            <select name="role" id="role">
                <option value="User" selected>User</option>
                <option value="Admin">Admin</option>
            </select>
        </div>

        <button type="submit">SUBMIT</button>
    </form>
</body>
</html>