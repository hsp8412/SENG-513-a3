<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == false) {
    header("Location: unauthorized.php");
    exit();
}

try {
    $stmt = $pdo->query("SELECT id, username FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users_data.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['User ID', 'Username']);

    foreach ($users as $user) {
        fputcsv($output, [$user['id'], $user['username']]);
    }

    fclose($output);
    exit();
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}