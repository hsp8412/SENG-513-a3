<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css">
    <title>User Dashboard</title>
</head>

<body>
    <div class="dashboard-content">
        <h2>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <a href="logout.php">Sign out</a>
    </div>
</body>

</html>