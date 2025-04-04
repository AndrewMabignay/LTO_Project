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
    // echo $id;

    $editVerification = '';

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        
        $checkQuery = "SELECT ID FROM accounts WHERE Name = ? AND ID != ?";
        $checkStmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "si", $name, $id);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            $editVerification = "This Name is already taken!";
        } else {
            $query = "UPDATE accounts SET Name = ?, Age = ?, Address = ?, Password = ?, Role = ? WHERE ID = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                // echo 'Testing Gumana';

                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sisssi", $name, $age, $address, $password, $role, $id);
            
                // Execute and check
                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $editVerification = "Account updated successfully!";
                    } else {
                        $editVerification = "No changes made.";
                    }
                } else {
                    echo "Error updating record: " . mysqli_stmt_error($stmt);
                }            
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

    <link rel="stylesheet" href="../../design/assets/editAccount.css">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <img class="bg-image" src="../../design/assets/img/ltoLogin.png" alt="LTO Background">
    <div class="bg-overlay"></div>

    <a href="../admin/accounts.php" class="back-container">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="form-container">
        <h2>Edit Account</h2>

        <?php 
            if ($result = mysqli_fetch_array($retrieve)): 
        ?>
            <form action="editAccount.php" method="POST">
                <input type="number" hidden name="id" value="<?php echo $id ?>">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $result['Name'] ?>">
                </div>

                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $result['Age'] ?>" min="17" max="120" oninput="validateAge(this)">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="<?php echo $result['Address'] ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" value="<?php echo $result['Password'] ?>">
                </div>

                <div class="form-group role-container">
                    <label for="role">Role</label>
                    <select name="role" id="role">
                        <option value="User" <?php echo ($result['Role'] == 'User') ? 'selected' : ''; ?>>User</option>
                        <option value="Admin" <?php echo ($result['Role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <?php if ($editVerification == 'Account updated successfully!'):?>
                    <p style="color: green; font-size: 13px; margin-bottom: 10px;"><?php echo $editVerification?></p>
                <?php endif;?>

                <?php if ($editVerification == 'No changes made.'):?>
                    <p style="color: grey; font-size: 13px; margin-bottom: 10px;"><?php echo $editVerification?></p>
                <?php endif;?>

                <?php if ($editVerification == 'This Name is already taken!'):?>
                    <p style="color: #A30000; font-size: 13px; margin-bottom: 10px;"><?php echo $editVerification?></p>
                <?php endif;?>

                <button type="submit" name="submit">SUBMIT</button>
            </form>
        <?php else: ?>
            <p>No record found.</p>
        <?php endif; ?>
    </div>

    <script>
        function validateAge(input) {
            const value = input.value;

            // If the value is less than 0 or greater than 120, set it to a valid range.
            if (value < 0) {
                input.value = '';
            } else if (value > 120) {
                input.value = 120;
            } else if (value == 0) {
                input.value = '';
            }
        }
    </script>
</body>
</html>