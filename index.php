<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> My Shop </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    
    <div class="container my-5">
        <h2>
            List of Clients
        </h2>
        <a href="/my_shop/modern/create.php" role="button" class="btn btn-primary"> 
            New Client
        </a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $db = "myshop";
                    
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $db);
                    
                    // Check connection
                    if ($conn->connect_error) {                    
                        echo "<div class='p-1 btn btn-danger rounded-circle' > </div>";
                        die("Connection failed: " . $conn->connect_error);
                    }

                    echo "<div class='p-1 btn btn-success rounded-circle' > </div>";

                    // connect to database table and read
                    $sql = "SELECT * FROM clients";
                    $stmt = $conn->prepare($sql);
                    
                    if ($stmt === false) {
                        die("Prepare failed: " . $conn->error);
                    }

                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td>" . htmlspecialchars($row['created_at']) . "</td>
                                <td>
                                    <a href='/my_shop/edit.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='/my_shop/delete.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>
                            ";
                        }
                        $stmt->close();
                    } else {
                        die("Invalid query: " . $conn->error);
                    }
                    
                    $conn->close();
            
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>