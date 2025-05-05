<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'archidict';

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    echo "Database '$dbname' created or already exists.<br>";
    
    // Select the database
    $conn->exec("USE `$dbname`");
    
    // Read SQL file
    $sql = file_get_contents('database.sql');
    
    // Execute SQL queries
    $conn->exec($sql);
    echo "Database tables created successfully.<br>";
    
    echo "Database setup complete!";
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>
