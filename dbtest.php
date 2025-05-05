<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'archidict';

// Test database connection
echo "<h2>Testing Database Connection</h2>";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to database: $dbname<br>";
    
    // Check if tables exist
    $tables = array("users", "terms", "term_relationships", "newsletters");
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            echo "Table '$table' exists<br>";
        } else {
            echo "Table '$table' does not exist<br>";
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Test file paths
echo "<h2>Testing File Paths</h2>";
$base_path = dirname(__FILE__);
echo "Base path: $base_path<br>";

$uploads_path = dirname($base_path) . '/uploads';
echo "Uploads path: $uploads_path<br>";
if (is_dir($uploads_path)) {
    echo "Uploads directory exists<br>";
    if (is_writable($uploads_path)) {
        echo "Uploads directory is writable<br>";
    } else {
        echo "Uploads directory is not writable<br>";
    }
} else {
    echo "Uploads directory does not exist<br>";
}

// Check subdirectories
$terms_path = $uploads_path . '/terms';
echo "Terms path: $terms_path<br>";
if (is_dir($terms_path)) {
    echo "Terms directory exists<br>";
    if (is_writable($terms_path)) {
        echo "Terms directory is writable<br>";
    } else {
        echo "Terms directory is not writable<br>";
    }
} else {
    echo "Terms directory does not exist<br>";
}

$newsletters_path = $uploads_path . '/newsletters';
echo "Newsletters path: $newsletters_path<br>";
if (is_dir($newsletters_path)) {
    echo "Newsletters directory exists<br>";
    if (is_writable($newsletters_path)) {
        echo "Newsletters directory is writable<br>";
    } else {
        echo "Newsletters directory is not writable<br>";
    }
} else {
    echo "Newsletters directory does not exist<br>";
}

// Test sessions
echo "<h2>Testing Sessions</h2>";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['test'] = 'Session test value';
echo "Session ID: " . session_id() . "<br>";
echo "Session test value: " . $_SESSION['test'] . "<br>";
?>
