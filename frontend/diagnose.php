<?php
/**
 * Diagnostic file to check class loading
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Class Loading Diagnostic</h1>";

// Debug information about the current file
echo "<h2>File Information</h2>";
echo "<p>Current file: " . __FILE__ . "</p>";
echo "<p>Current directory: " . __DIR__ . "</p>";

// Check if init.php exists
echo "<h2>File Existence Check</h2>";
$initPath = __DIR__ . '/includes/init.php';
echo "<p>Init path: " . $initPath . "</p>";
echo "<p>Init file exists: " . (file_exists($initPath) ? 'Yes' : 'No') . "</p>";

// Try to include the init file
echo "<h2>Include Process</h2>";
try {
    require_once 'includes/init.php';
    echo "<p>Successfully included init.php</p>";
} catch (Exception $e) {
    echo "<p>Error including init.php: " . $e->getMessage() . "</p>";
}

// Check class existence
echo "<h2>Class Existence</h2>";
echo "<p>Term class exists: " . (class_exists('Term') ? 'Yes' : 'No') . "</p>";
echo "<p>Newsletter class exists: " . (class_exists('Newsletter') ? 'Yes' : 'No') . "</p>";
echo "<p>Database class exists: " . (class_exists('Database') ? 'Yes' : 'No') . "</p>";

// Try to instantiate objects
echo "<h2>Object Instantiation</h2>";
try {
    $db = new Database();
    echo "<p>Database object created successfully</p>";
} catch (Exception $e) {
    echo "<p>Error creating Database object: " . $e->getMessage() . "</p>";
}

try {
    $termObj = new Term();
    echo "<p>Term object created successfully</p>";
} catch (Exception $e) {
    echo "<p>Error creating Term object: " . $e->getMessage() . "</p>";
}

try {
    $newsletterObj = new Newsletter();
    echo "<p>Newsletter object created successfully</p>";
} catch (Exception $e) {
    echo "<p>Error creating Newsletter object: " . $e->getMessage() . "</p>";
}

echo "<h2>Conclusion</h2>";
echo "<p>If all classes exist and all objects were created successfully, the issue should be fixed.</p>";
?>
