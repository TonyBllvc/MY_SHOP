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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare the SQL statement
        $sql = "DELETE FROM clients WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            // Optionally handle prepare error
            header("Location: /my_shop/old_system/index.php");
            exit;
        }

        // Bind parameters
        $stmt->bind_param("i", $id);
        
        // Execute the statement
        $stmt->execute();
        
        $stmt->close();
    }
    
    $conn->close();
    
    header("Location: /my_shop/old_system/index.php");
    exit;
?>