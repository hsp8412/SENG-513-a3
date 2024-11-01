<?php
session_start();
include 'db.php';

$errors = [];


if (!isset($_SESSION['user_id'])) {
    header('Location: unauthorized.php');
    exit();
}

if ($_SESSION['is_admin']) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password)) {
        $errors['current_password'] = 'Current password is required.';
    }

    if (empty($new_password)) {
        $errors['new_password'] = 'New password is required.';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Confirm password is required.';
    }

    if ($new_password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($user['salt'] . $current_password, $user['password'])) {
            $new_password = password_hash($user['salt'] . $new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$new_password, $_SESSION['user_id']]);
            // JavaScript alert and redirect
            echo "<script>
             alert('Password changed successfully. You will be logged out.');
             window.location.href = 'logout.php';
           </script>";
            exit();
            // header('Location: logout.php');
            // exit();
        } else {
            $errors['current_password'] = 'Invalid password.';
        }
    }
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
            <h1 class="title">Reset Password</h1>
            <form action="" method="POST">
                <div class="input-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                    <?php if (isset($errors['current_password'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['current_password']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <?php if (isset($errors['new_password'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['new_password']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['confirm_password']); ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn">Reset Password</button>
            </form>
        </div>
    </div>

</body>

</html>