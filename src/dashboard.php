<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: unauthorized.php');
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
        <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a href="logout.php">Sign out</a>
    </div>
    <div class="reset-pwd-container">
        <div class="card">
            <h2 class="title">Reset Password</h2>
            <form action="reset_password.php" method="POST">
                <div class="input-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>


                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>

</body>

</html>