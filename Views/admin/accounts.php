<?php 
    require_once '../../config.php';
    
    $query = "SELECT * FROM accounts"; 
    $retrieve = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <div class="title">
        <label for="add-accounts">List of Accounts</label>
        <a href="addAccount.php">New</a>
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
            </tr>

            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>