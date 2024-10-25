<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['name'] !== 'admin') {
    header("Location: Index.php");
    exit();
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
    <h2>Welcome to the Admin Page, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

    <!-- Admin actions go here, like managing users -->
    <p>Here you can manage users, view reports, etc.</p>

    <!-- Log out link -->
    <!-- <a href="logout.php">Log Out</a> -->
</body>

</html>