<?php
$host = 'db'; // The hostname (IP address automatically assigned) of the database server.
$db = getenv('MYSQL_DATABASE'); //name
$user = getenv('MYSQL_USER'); //login details
$pass = getenv('MYSQL_PASSWORD');

#PDO - PHP Data Objects is a consistent interface for interacting with different types of dbs
#try/catch attempts to connect to DB

try {
    #creates new instance of PDO class, using connection parameters
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    #sets error reporting mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // echo "username: $user\n";
    // echo "password: $pass\n";
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>