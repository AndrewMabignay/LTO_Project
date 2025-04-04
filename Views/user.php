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
    
    $invalidPlate = '';
    $name = $_SESSION['name'];
    // echo $name;

    if (isset($_POST['search'])) {
        $userID = $_POST['userId'];
        $plateNumber = $_POST['plateNumber'];

        $query = "SELECT Model, Official_Receipt, Certificate_Registration, PaymentControlNumber, Date FROM registered WHERE UserID = ? AND Plate = ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("is", $userID, $plateNumber);

        $stmt->execute();
        $search = $stmt->get_result();
        
        if ($search->num_rows > 0) {
            $fields = $search->fetch_assoc();
            $model = $fields['Model'];
            $officialReceipt = $fields['Official_Receipt'];
            $certificateRegistration = $fields['Certificate_Registration'];
            $paymentController = $fields['PaymentControlNumber'];
            // echo $paymentController;
            echo $model;
        } else {
            /* Invalid Search */
            $invalidPlate = 'Invalid Plate Search. Please try again!'; 
        }

    }

    $fieldsFilledUp = '';

    if (isset($_POST['register'])) {
        $userID = $_POST['userId'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $model = $_POST['model'];
        $plateNumber = $_POST['plateNumber'];
        $officialReceipt = $_POST['officialReceipt'];
        $certificateRegistration = $_POST['certificateRegistration'];
        $paymentController = $_POST['paymentControlNumber'];
        $date = $_POST['date'];

        if (empty($model) || empty($plateNumber) || empty($officialReceipt) || empty($certificateRegistration) || empty($paymentController)) {
            $fieldsFilledUp = 'Fill Up All Fields!';
            // echo $fieldsFilledUp;
        } else {
            $query = "SELECT * FROM registered WHERE Plate = ? OR Official_Receipt = ? OR Certificate_Registration = ? OR PaymentControlNumber = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $plateNumber, $officialReceipt, $certificateRegistration, $paymentController);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $fieldsFilledUp = "Invalid Input. Duplicate Invalid!.";
                $model = '';
                $plateNumber = '';
                $officialReceipt = '';
                $certificateRegistration = '';
                $paymentController = '';
                // echo 'Bawal'; 
            } else {
                $query = "INSERT INTO registered(UserID, Name, Address, Model, Plate, Official_Receipt, Certificate_Registration, Date, PaymentControlNumber) VALUES ('$userID', '$name', '$address', '$model', '$plateNumber', '$officialReceipt', '$certificateRegistration', '$date', '$paymentController');";
                $insertResult = \mysqli_query($conn, $query); 
                echo $insertResult ? 'Data Successfully Added' : 'Error : ' . \mysqli_error($conn);
                $fieldsFilledUp = "Successfully Registered";

                $plateNumber = '';
                $officialReceipt = '';
                $certificateRegistration = '';
                $paymentController = '';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../public/user.css">
</head>
<body>
    

    
<br>

    <div class="container">
        <header>User Dashboard</header>

        <form action="user.php" method="POST">
            <!-- ------------------- PERSONAL DETAILS ------------------- -->
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                    
                        <!-- ================ 1. USER ID ================ -->
                        <div class="input-field">
                            <label for="userId">User ID</label>
                            <input type="number" name="userId" id="userId" value="<?php echo $_SESSION['id'] ?>" readonly>
                        </div>

                        <!-- ================ 2. NAME ================ -->
                        <div class="input-field">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="<?php echo $_SESSION['name']?>" readonly>            
                        </div>

                        <!-- ================ 3. AGE ================ -->
                        <div class="input-field">                            
                            <label for="age">Age</label>
                            <input type="number" name="age" id="age" value="<?php echo $_SESSION['age'] ?>" readonly>
                        </div>

                        <!-- ================ 4. ADDRESS ================ -->
                        <div class="input-field">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" value="<?php echo $_SESSION['address'] ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ------------------- REGISTERED MODEL ------------------- -->
            <div class="form second">
                <div class="details model">
                    <span class="title">Model Details</span>

                    <div class="fields">
                    
                        <!-- ================ 5. MAKE / MODEL ================ -->
                        <div class="input-field">
                            <label for="model">Make / Model</label>
                            <input type="text" name="model" id="model" value="<?php echo empty($model) ?  '' : $model; ?>">            
                        </div>

                        <!-- ================ 6. PLATE # ================ -->
                        <div class="input-field">
                            <label for="plateNumber">Plate #</label>
                            <input type="text" name="plateNumber" id="plateNumber" value="<?php echo empty($plateNumber) ?  '' : $plateNumber; ?>">                        
                        </div>

                        <button class="search" type="submit" name="search">SEARCH</button>

                        <!-- ================ 7. OFFICIAL RECEIPT ================ -->
                        <div class="input-field">                            
                            <label for="officialReceipt">Official Receipt</label>
                            <input type="text" name="officialReceipt" id="officialReceipt" value="<?php echo empty($officialReceipt) ?  '' : $officialReceipt; ?>">            
                        </div>

                        <!-- ================ 8. CERTIFICATE OF REGISTRATION ================ -->
                        <div class="input-field">
                            <label for="certificateRegistration">Certificate of Registration</label>
                            <input type="text" name="certificateRegistration" id="certificateRegistration" value="<?php echo empty($certificateRegistration) ?  '' : $certificateRegistration; ?>">            
                        </div>

                        <!-- ================ 9. PAYMENT CONTROL # ================ -->
                        <div class="input-field">
                            <label for="paymentControlNumber">Payment Control #</label>
                            <input type="text" name="paymentControlNumber" id="paymentControlNumber" value="<?php echo empty($paymentController) ?  '' : $paymentController; ?>">
                        </div>

                        <!-- ================ 10. DATE ================ -->
                        <div class="input-field">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>

            <?php if ($fieldsFilledUp == 'Successfully Registered'): ?>
                <p style="color: green; font-size: 14px; margin-top: 10px;"><?php echo $fieldsFilledUp; ?></p>
            <?php elseif ($fieldsFilledUp == 'Fill Up All Fields!' || $fieldsFilledUp == 'Invalid Input. Duplicate Invalid!.'): ?>
                <p style="color: #A30000; font-size: 14px; margin-top: 10px;"><?php echo $fieldsFilledUp; ?></p>
            <?php endif; ?>

            
            <?php if (!empty($invalidPlate)): ?>
                <p style="color: #A30000; font-size: 14px; margin-top: 10px;"><?php echo $invalidPlate; ?></p>
            <?php endif; ?>


            <div class="button-container">
                <button type="submit" name="register">REGISTER</button>
                <a href="../Auth/logout.php">LOG OUT</a>
            </div>
                </div>
            </div>
        </form>
    </div>

    <br>

</body>
</html>