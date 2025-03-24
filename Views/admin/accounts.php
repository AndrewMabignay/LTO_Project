<?php
    session_start();

    if (!isset($_SESSION['id'])):
        header("Location: ../../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "Admin"):
        header("Location: ../user.php");
        exit;
    endif;    

    require_once '../../config.php';
    $id = $_SESSION['id'];

    $query = "SELECT * FROM accounts WHERE ID <> '$id'"; 
    $retrieve = \mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- External CSS -->
    <link rel="stylesheet" href="../../public/table.css">
</head>
<body>
    <div class="title">
        <label for="add-accounts">List of Accounts</label>
        <a href="addAccount.php">
            <i class="fas fa-plus"></i>
            Create
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Password</th>
                <th>Role</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php while($result = \mysqli_fetch_array($retrieve)): ?>  
            <tr>
                <td><?php echo $result['ID'] ?></td>
                <td><?php echo $result['Name'] ?></td>
                <td><?php echo $result['Age'] ?></td>
                <td><?php echo $result['Address'] ?></td>
                <td><?php echo $result['Password'] ?></td>
                <td><?php echo $result['Role'] ?></td>
                <td>
                    <a href="editAccount.php?id=<?php echo base64_encode($result['ID'])?>" class="edit"><i class="fa-solid fa-pen"></i></a>
                    <a href="deleteAccount.php?id=<?php echo base64_encode($result['ID'])?>" class="delete"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>

            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
