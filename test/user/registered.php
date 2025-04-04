<?php 
    session_start();

    if (!isset($_SESSION['id'])):
        header("Location: ../../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "User"):
        header("Location: ../../Views/admin.php");
        exit;
    endif;    

    require_once '../../config.php';
    
    $query = "SELECT * FROM registered WHERE Name = '$_SESSION[name]'"; 
    $retrieve = \mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="../../design/assets/accounts.css">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<img class="bg-image" src="../../design/assets/img/ltoLogin.png" alt="LTO Background">
    <div class="bg-overlay"></div>

    <a href="../admin.php" class="back-container">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="title">
        <label for="add-accounts">Registered Plate #</label>
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
                <th>Payment Control #</th>
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
                <td><?php echo $result['PaymentControlNumber'] ?></td>
                <td><?php echo $result['Date'] ?></td>
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