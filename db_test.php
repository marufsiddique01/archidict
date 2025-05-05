<?php
/**
 * Database connection test for ArchiDict
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the configuration file directly
require_once __DIR__ . '/frontend/includes/config.php';

echo "<h1>Database Connection Test</h1>";

try {
    // Test database connection directly
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    
    echo "<p>Attempting to connect to database...</p>";
    echo "<p>Host: " . DB_HOST . "</p>";
    echo "<p>Database: " . DB_NAME . "</p>";
    echo "<p>User: " . DB_USER . "</p>";
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    echo "<p><strong>Success:</strong> Connected to database!</p>";
    
    // Test a simple query
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    
    echo "<h2>Database Tables:</h2>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . htmlspecialchars($table[0]) . "</li>";
    }
    echo "</ul>";
    
    // Check for terms table and count records
    $stmt = $pdo->query("SELECT COUNT(*) FROM terms");
    $count = $stmt->fetchColumn();
    
    echo "<p>Found " . $count . " records in the terms table.</p>";
    
} catch (PDOException $e) {
    echo "<p><strong>Error:</strong> Could not connect to database!</p>";
    echo "<p>" . $e->getMessage() . "</p>";
}
