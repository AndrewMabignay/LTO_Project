<?php 
    session_start();
    require '../../config.php';

    if (!isset($_SESSION['id'])):
        header("Location: ../../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "Admin"):
        header("Location: ../user.php");
        exit;
    endif;    

    // $id = $_SESSION['id']; 
    $id = isset($_GET['id']) ? base64_decode($_GET['id']) : (isset($_POST['id']) ? $_POST['id'] : '');
    echo $id;

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        
        $query = "UPDATE accounts SET Name = ?, Age = ?, Address = ?, Password = ?, Role = ? WHERE ID = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            echo 'Testing Gumana';

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sisssi", $name, $age, $address, $password, $role, $id);
        
            // Execute and check
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo "Account updated successfully!";
                } else {
                    echo "No changes made.";
                }
            } else {
                echo "Error updating record: " . mysqli_stmt_error($stmt);
            }            
        }
    }

    $query = "SELECT Name, Age, Address, Password, Role FROM accounts WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $retrieve = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
</head>
<body>
    <?php 
    if ($result = mysqli_fetch_array($retrieve)): 
    ?>
    <form action="editAccount.php" method="POST">
        <input type="number" name="id" value="<?php echo $id ?>">

        <div class="name-container">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $result['Name'] ?>">
        </div>

        <div class="name-container">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" value="<?php echo $result['Age'] ?>">
        </div>

        <div class="address-container">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?php echo $result['Address'] ?>">
        </div>

        <div class="password-container">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php echo $result['Password'] ?>">
        </div>

        <div class="role-container">
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="User" <?php echo ($result['Role'] == 'User') ? 'selected' : ''; ?>>User</option>
                <option value="Admin" <?php echo ($result['Role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <button type="submit" name="submit">SUBMIT</button>
    </form>
    <?php else: ?>
        <p>No record found.</p>
    <?php endif; ?>
</body>
</html>