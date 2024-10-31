<?php
session_start();
include 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Get the input data
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // Check if the username already exists in the database
    if (empty($errors)) {
        $get_user_by_username_query = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($get_user_by_username_query);
        $stmt->execute([$username]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $errors['username'] = 'Username is already taken.';
        }
    }

    if (empty($errors)) {
        $salt = bin2hex(random_bytes(16));
        $saltedPassword = $salt . $password;
        $hashedPassword = password_hash($saltedPassword, PASSWORD_BCRYPT);

        $add_user_query = "INSERT INTO users (username, password, salt) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($add_user_query);

        // Execute the statement and bind the parameters directly in the execute() method
        if ($stmt->execute([$username, $hashedPassword, $salt])) {
            $_SESSION['success'] = 'Registration successful! Please log in.';
            // Redirect to index if registration is successful
            header('Location: /');
            exit();
        } else {
            // Handle error if the query fails
            $errors['general'] = 'Registration failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="./styles/styles.css">
</head>

<body>
    <div class="content">
        <div class="card">
            <h1 class="title">Sign up</h1>
            <form method="POST">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username"
                        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" />
                    <?php if (isset($errors['username'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['username']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" />
                    <?php if (isset($errors['password'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <label for="password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" />
                    <?php if (isset($errors['confirm_password'])): ?>
                        <p style="color:red;"><?php echo htmlspecialchars($errors['confirm_password']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="actions-container">
                    <button type="submit" class="btn">Register</button>
                    <a class="back-to-login-link" href="/">Back to login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>