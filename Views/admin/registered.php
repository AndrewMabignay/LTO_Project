<?php 
    require_once '../../config.php';
    
    $query = "SELECT * FROM registered"; 
    $retrieve = \mysqli_query($conn, $query);

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
        <label for="add-accounts">List of Registered</label>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Model</th>
                <th>Plate</th>
                <th>Official_Receipt</th>
                <th>Certificate_Registration</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while($result = \mysqli_fetch_array($retrieve)): ?>  
            <tr>
                <td><?php echo $result['Name'] ?></td>
                <td><?php echo $result['Address'] ?></td>
                <td><?php echo $result['Model'] ?></td>
                <td><?php echo $result['Plate'] ?></td>
                <td><?php echo $result['Official_Receipt'] ?></td>
                <td><?php echo $result['Certificate_Registration'] ?></td>
                <td><?php echo $result['Date'] ?></td>
            </tr>

            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>