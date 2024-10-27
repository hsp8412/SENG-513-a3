<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == false) {
    header('Location: unauthorized.php');
    exit();
}


if (isset($_POST['delete']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // check if the user with the id exists
    $get_user_by_id_query = "SELECT * From users WHERE id = ?";
    $stmt = $pdo->prepare($get_user_by_id_query);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($row)) {
        $_SESSION['delete_error'] = "User not found.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['delete_msg'] = "User delete successfully.";
    }
}

// Redirect back to the users list
header("Location: admin.php");
exit;