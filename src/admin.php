<?php session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == false) {
    header("Location: unauthorized.php");
    exit();
} // Fetch all users 
try {
    $stmt = $pdo->query("SELECT id, username FROM
    users");
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
    <link rel="stylesheet" type="text/css" href="./styles/styles.css">

    <title>Admin Page</title>
</head>

<body>
    <div>
        <div class="admin-header">
            <h1 class="admin-title">Welcome to the admin page!</h1>
            <a href="logout.php" class="admin-btn">Log Out</a>
        </div>
        <div class="table-container">
            <?php if (empty($users)): ?>
                <p>Sorry, there is no user in the database.</p>
            <?php else: ?>
                <div>
                    <input id="search-bar" class="search-bar" placeholder="Search..." onkeyup="filterTable()" />
                </div>
                <table id="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td>
                                    <form action="delete_user.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                        <div>
                                            <button type="submit" name="delete" class="admin-btn">Delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script src="./filter.js"></script>
</body>

</html>