<?php


    $id = $name = $email = $phone = $address = "";
    $error_message = $success_message = '';

    
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        // GET Method: Show the data of the client
        if(!isset($GET['id'])){
            header("Location: /my_shop/index.php");
        }
    }else {
        // POST Method: UPDATE the data of the client

    }
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
            <input type="hidden" value="<?php echo $id; ?>">
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
                    <a href="/my_shop/index.php" class="btn btn-outline-primary" role='button' > Cancel </a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>