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
        <a href="/my_shop/modern_system/create/pdo/index.php" role="button" class="btn btn-primary"> 
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
                    $dsn = 'mysql:host=localhost;dbname=myshop';
                    $username = 'root';
                    $password = '';

                    try {
                        $conn = new PDO($dsn, $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die("Connection failed: " . $e->getMessage());
                    }

                    // Prepare and execute
                    $sql = 'SELECT * FROM clients';
                    $stmt = $conn->prepare($sql);

                    try {
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "
                            <tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td>" . htmlspecialchars($row['created_at']) . "</td>
                                <td>
                                    <a href='/my_shop/modern_system/edit/index.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='/my_shop/modern_system/delete/index.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>
                            ";
                        }
                    } catch (PDOException $e) {
                        die("Query failed: " . $e->getMessage());
                    }

                    // No explicit close needed
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>