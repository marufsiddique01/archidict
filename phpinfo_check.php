<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>PHP Configuration Check</h1>";

// Check PHP version
echo "<h2>PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";

// Check loaded extensions
echo "<h2>Loaded Extensions</h2>";
$extensions = get_loaded_extensions();
echo "PDO: " . (in_array('PDO', $extensions) ? "Loaded" : "Not loaded") . "<br>";
echo "MySQL: " . (in_array('mysql', $extensions) ? "Loaded" : "Not loaded") . "<br>";
echo "MySQLi: " . (in_array('mysqli', $extensions) ? "Loaded" : "Not loaded") . "<br>";
echo "PDO_MySQL: " . (in_array('pdo_mysql', $extensions) ? "Loaded" : "Not loaded") . "<br>";
echo "GD: " . (in_array('gd', $extensions) ? "Loaded" : "Not loaded") . "<br>";
echo "Fileinfo: " . (in_array('fileinfo', $extensions) ? "Loaded" : "Not loaded") . "<br>";

// Check session configuration
echo "<h2>Session Configuration</h2>";
echo "Session auto_start: " . ini_get('session.auto_start') . "<br>";
echo "Session save_path: " . ini_get('session.save_path') . "<br>";
echo "Session save_handler: " . ini_get('session.save_handler') . "<br>";

// Check upload configuration
echo "<h2>Upload Configuration</h2>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";
echo "max_input_time: " . ini_get('max_input_time') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";

// Check directory paths
echo "<h2>Directory Paths</h2>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Current Script: " . __FILE__ . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";

// Check permissions
echo "<h2>File and Directory Permissions</h2>";
$root_path = dirname(__FILE__);
echo "Root Path: $root_path<br>";
echo "Root is writable: " . (is_writable($root_path) ? "Yes" : "No") . "<br>";

$uploads_path = $root_path . '/uploads';
echo "Uploads Path: $uploads_path<br>";
echo "Uploads exists: " . (file_exists($uploads_path) ? "Yes" : "No") . "<br>";
echo "Uploads is writable: " . (is_writable($uploads_path) ? "Yes" : "No") . "<br>";

// Check server information
echo "<h2>Server Information</h2>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Server Port: " . $_SERVER['SERVER_PORT'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Server Protocol: " . $_SERVER['SERVER_PROTOCOL'] . "<br>";
echo "Server API: " . PHP_SAPI . "<br>";
?>
