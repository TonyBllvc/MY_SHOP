<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "myshop";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $id = 0;
    $name = $email = $phone = $address = "";
    $error_message = $success_message = '';
    
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        // GET Method: Show the data of the client
        if (!isset($_GET['id'])) { // if id does not exist
            header("Location: /my_shop/old_system/index.php");
            exit;
        }

        $id = $_GET["id"]; // read the id from database

        // Prepare the SQL statement
        $sql = "SELECT * FROM clients WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $error_message = "Prepare failed: " . $conn->error;
        } else {
            // Bind parameters
            $stmt->bind_param("i", $id);
            
            // Execute the statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if (!$row) {
                    header("Location: /my_shop/old_system/index.php");
                    exit;
                }

                $name = $row['name'];
                $email = $row['email'];
                $phone = $row['phone'];
                $address = $row['address'];
            } else {
                $error_message = "Query failed: " . $conn->error;
            }
            
            $stmt->close();
        }
    } else {
        // POST Method: UPDATE the data of the client
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)) {
            $error_message = "All the fields are required";
        } else {
            // Prepare the SQL statement
            $sql = "UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                $error_message = "Prepare failed: " . $conn->error;
            } else {
                // Bind parameters
                $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
                
                // Execute the statement
                try {
                    if ($stmt->execute()) {
                        $success_message = "Client updated successfully.";
                        header("Location: /my_shop/old_system/index.php");
                        exit;
                    }
                } catch (mysqli_sql_exception $e) {
                    $error_message = $e->getMessage();
                }
                
                $stmt->close();
            }
        }
    }
    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop - Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
   
</head>
<body>
    <div class='container my-5'>
        <h2>Edit Client</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $error_message; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
       
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $success_message; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <!-- Have a hidden input contain the id of the data to edit -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name </label>
                <div class='col-sm-6'>
                    <input type="text" class="form-control" value='<?php echo htmlspecialchars($name); ?>' name="name">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email: </label>
                <div class='col-sm-6'>
                    <input type="email" class="form-control" value='<?php echo htmlspecialchars($email); ?>' name="email">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone Number </label>
                <div class='col-sm-6'>
                    <input type="text" class="form-control" value='<?php echo htmlspecialchars($phone); ?>' name="phone">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address </label>
                <div class='col-sm-6'>
                    <input type="text" class="form-control" value='<?php echo htmlspecialchars($address); ?>' name="address">
                </div>
            </div>
           
            <div class="row mb-3">
                <div class='offset-sm-3 col-sm-3 d-grid'>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
                <div class='col-sm-3 d-grid'>
                    <a href="/my_shop/old_system/index.php" class="btn btn-outline-primary" role='button' > Cancel </a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>