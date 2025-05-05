<?php
// Simple test to check class inclusion
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check current file location
echo "Current file: " . __FILE__ . "<br>";
echo "Current directory: " . __DIR__ . "<br>";

// Try to include the init file
require_once __DIR__ . '/includes/init.php';

// Check if Term class exists
echo "Does Term class exist? " . (class_exists('Term') ? 'Yes' : 'No') . "<br>";

// Try to instantiate a Term object
try {
    $termObj = new Term();
    echo "Successfully created Term object<br>";
    
    // Try a simple method
    $terms = $termObj->getAll();
    echo "Found " . count($terms) . " terms in the database<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>
