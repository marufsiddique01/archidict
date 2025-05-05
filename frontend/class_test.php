<?php
/**
 * Test script to check if Term class can be properly loaded
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Output the current working directory
echo "Current working directory: " . getcwd() . "<br>";

// Include the bootstrap file
require_once __DIR__ . '/bootstrap.php';

// Check if the Term class exists
if (class_exists('Term')) {
    echo "Term class exists.<br>";
    
    try {
        // Try to create an instance
        $term = new Term();
        echo "Term instance created successfully.<br>";
        
        // Try to call a method
        $allTerms = $term->getAll();
        echo "Found " . count($allTerms) . " terms in the database.<br>";
        
        echo "<pre>";
        var_dump($term);
        echo "</pre>";
    } catch (Exception $e) {
        echo "Error creating Term instance: " . $e->getMessage() . "<br>";
    }
} else {
    echo "Term class does not exist.<br>";
    
    // Check which classes are defined
    echo "Available classes: <br>";
    $classes = get_declared_classes();
    foreach ($classes as $class) {
        echo "- $class<br>";
    }
}
?>
