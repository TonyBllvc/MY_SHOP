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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare the SQL statement
        $sql = 'DELETE FROM clients WHERE id = :id';
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            // Optionally handle error, but for delete, proceed to redirect
        }
    }

    // No explicit close needed

    header("Location: /my_shop/modern_system/index.php");
    exit;
?>