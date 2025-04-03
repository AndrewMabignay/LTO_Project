<?php

require_once '../../config.php';

session_start();

if (!isset($_SESSION['id'])):
    header("Location: ../../Auth/login.php");
    exit;
elseif ($_SESSION['role'] !== "Admin"):
    header("Location: ../user.php");
    exit;
endif;    

$addVerification = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "SELECT * FROM accounts WHERE Name = ?";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param('s', $name);   

    $stmt->execute();
    $search = $stmt->get_result();
        
    if ($search->num_rows > 0) {
        $addVerification = 'Duplicate name invalid!';
    } else {
        $query = "INSERT INTO accounts(Name, Age, Address, Password, Role) VALUES ('$name', '$age', '$address', '$password', '$role')";
        $insertFields = \mysqli_query($conn, $query);

        echo $insertFields === true ? header("Location: accounts.php") : 'Not Successfully Inserted!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LTO Account Registration</title>
    
    <link href="../../design/assets/addAccount.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <a href="../admin/accounts.php" class="back-container">
        <i class="fas fa-arrow-left"></i>
    </a>

    <form action="addAccount.php" method="POST">
        <div class="form-header">LTO Account Registration</div>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" placeholder="Enter your age" min="0" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="Enter your address" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>

        <div class="form-group role-container">
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="User" selected>User</option>
                <option value="Admin">Admin</option>
            </select>
        </div>

        <?php if (!$addVerification == ''):?>
            <p style="color: #A30000; font-size: 13px; margin-bottom: 10px;"><?php echo $addVerification?></p>
        <?php endif;?>

        <button type="submit">REGISTER</button>
    </form>
</body>
</html>