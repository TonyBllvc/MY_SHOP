<?php
    $dsn = 'mysql:host=localhost;dbname=myshop';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    $name = $email = $phone = $address = '';
    $error_message = $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $error_message = 'All the fields are required';
        } else {
            // Prepare the SQL statement
            $sql = 'INSERT INTO clients (name, email, phone, address) VALUES (:name, :email, :phone, :address)';
            $stmt = $conn->prepare($sql);

            // Bind parameters (named for readability)
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);

            try {
                if ($stmt->execute()) {
                    $success_message = 'Client added successfully.';
                    $name = $email = $phone = $address = '';
                    header('Location: /my_shop/modern_system/index.php');
                    exit;
                }
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
            }
        }
    }

    // No need to close PDO connection explicitly; it closes at script end
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop - Create new client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div class='container my-5'>
        <h2> New Client</h2>
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
                    <a href="/my_shop/modern_system/index.php" class="btn btn-outline-primary" role='button' > Cancel </a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>