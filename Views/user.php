<?php 
    require '../config.php';

    session_start();

    if (!isset($_SESSION['id'])):
        header("Location: ../Auth/login.php");
        exit;
    elseif ($_SESSION['role'] !== "User"):
        header("Location: admin.php");
        exit;
    endif;    

    if (isset($_POST['search'])) {
        $plateNumber = $_POST['plateNumber'];
        echo $plateNumber;

        $query = "SELECT Official_Receipt, Certificate_Registration FROM registered WHERE plate = ?";
        $statement = $conn->prepare($query);
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $plateNumber);
        $stmt->execute();
        $search = $stmt->get_result();
        
        if ($search->num_rows > 0) {
            $fields = $search->fetch_assoc();
            $officialReceipt = $fields['Official_Receipt'];
            $certificateRegistration = $fields['Certificate_Registration'];
        }
        // if ($search->num_rows > 0) {
        //     $fields = $result->fetch_assoc();
        //     $officialReceipt = $fields['Official_Receipt'];
        //     $certificateRegistration = $fields['Certificate_Registration'];
        // }

    }

    if (isset($_POST['register'])) {
        // $userID = $_POST['userId'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $model = $_POST['model'];
        $plateNumber = $_POST['plateNumber'];
        $officialReceipt = $_POST['officialReceipt'];
        $certificateRegistration = $_POST['certificateRegistration'];
        $paymentController = $_POST['paymentControlNumber'];
        $date = $_POST['date'];

        // echo $name . $age . $address . $model . $plateNumber . $officialReceipt . $certificateRegistration . $paymentController . $date;

        $query = "INSERT INTO registered(Name, Address, Model, Plate, Official_Receipt, Certificate_Registration, Date) VALUES ('$name', '$address', '$model', '$plateNumber', '$officialReceipt', '$certificateRegistration', '$date');";
        
        $insertResult = \mysqli_query($conn, $query); 

        echo $insertResult ? 'Data Successfully Added' : 'Error : ' . \mysqli_error($conn); 
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
    <h1>Hello User</h1>
    <form action="user.php" method="POST">

        <!-- ============== 1. USER ID ============== -->
        <div class="input-container">
            <label for="userId">User ID</label>
            <input type="number" name="userId" id="userId" value="<?php echo $_SESSION['id'] ?>" readonly>
        </div>

        <!-- ============== 2. NAME ============== -->
        <div class="input-container">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $_SESSION['name']?>" readonly>
        </div>

        <!-- ============== 3. AGE ============== -->
        <div class="input-container">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" value="<?php echo $_SESSION['age'] ?>" readonly>
        </div>

        <!-- ============== 4. ADDRESS ============== -->
        <div class="input-container">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?php echo $_SESSION['address'] ?>" readonly>
        </div>

        <!-- ------------------- REGISTERED MODEL ------------------- -->
        <!-- ============== 1. MAKE / MODEL ============== -->
        <div class="input-container">
            <label for="model">Make / Model</label>
            <input type="text" name="model" id="model">
        </div>

        <!-- ============== 2. PLATE NO. ============== -->
        <div class="input-container">
            <label for="plateNumber">Plate #</label>
            <input type="text" name="plateNumber" id="plateNumber" value="<?php echo empty($plateNumber) ?  '' : $plateNumber; ?>">
            <button type="submit" name="search">SUBMIT</button>
        </div>

        <!-- ============== 3. Official Receipt ============== -->
        <div class="input-container">
            <label for="officialReceipt">Official Receipt</label>
            <input type="text" name="officialReceipt" id="officialReceipt" value="<?php echo empty($officialReceipt) ?  '' : $officialReceipt; ?>">
        </div>

        <!-- ============== 4. Certificate of Registration ============== -->
        <div class="input-container">
            <label for="certificateRegistration">Certificate of Registration</label>
            <input type="text" name="certificateRegistration" id="certificateRegistration" value="<?php echo empty($certificateRegistration) ?  '' : $certificateRegistration; ?>">
        </div>

        <!-- ============== 5. Payment Control # ============== -->
        <div class="input-container">
            <label for="paymentControlNumber">Payment Control #</label>
            <input type="text" name="paymentControlNumber" id="paymentControlNumber">
        </div>

        <!-- ============== 6. Date ============== -->
        <div class="input-container">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="<?php echo date("Y-m-d"); ?>">
        </div>

        <div class="button-container">
            <button type="submit" name="register">REGISTER</button>
            <a href="../Auth/logout.php">LOG OUT</a>
        </div>
    </form>

</body>
</html>