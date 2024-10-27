<?php
session_start();
include 'db.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['name'] !== 'admin') {
//     header("Location: /");
//     exit();
// }
// Fetch all users
try {
    $stmt = $pdo->query("SELECT id, username FROM users"); // Adjust columns as necessary
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>

<body>
    <div>

        <a href="logout.php">Log Out</a>
    </div>
</body>

</html>