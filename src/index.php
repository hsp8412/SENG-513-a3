<?php
session_start();
include 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            header('Location: dashboard.php');
            exit();
        } else {
            $errors['login'] = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>My PHP Web Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/styles.css">
</head>

<body>
    <div class="content">
        <div class="card">
            <h1 class="title">Welcome to my PHP Web Page!</h1>
            <form method="POST">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username"
                        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                    <?php if (isset($errors['username'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['username']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                    <?php if (isset($errors['password'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="actions-container">
                    <?php if (isset($errors['login'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['login']); ?></p>
                    <?php endif; ?>
                    <button type="submit" class="btn">Login</button>
                </div>
            </form>
            <p class="sign-up-link">Don't have an account? <a href="register.php">Sign up</a></p>
        </div>
    </div>
</body>

</html>