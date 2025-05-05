<?php
/**
 * Diagnostic file to test class loading in ArchiDict
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>ArchiDict Diagnostic</h1>";

// Directory information 
echo "<h2>Directory Information</h2>";
echo "<p>Current working directory: " . getcwd() . "</p>";
echo "<p>Script location: " . __DIR__ . "</p>";

// Test init.php inclusion
echo "<h2>Testing Init File</h2>";

$initPath = __DIR__ . '/frontend/includes/init.php';
echo "<p>Init file path: " . $initPath . "</p>";
echo "<p>Init file exists: " . (file_exists($initPath) ? 'Yes' : 'No') . "</p>";

// Try including the file
try {
    echo "<p>Attempting to include init.php...</p>";
    require_once $initPath;
    echo "<p><strong>Success:</strong> init.php included without errors.</p>";
} catch (Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

// Check if classes are available
echo "<h2>Testing Classes</h2>";

$classes = ['Database', 'Term', 'Newsletter', 'Utils'];
foreach ($classes as $class) {
    echo "<p>Class '$class' exists: " . (class_exists($class) ? 'Yes' : 'No') . "</p>";
}

// Try creating instances
echo "<h2>Testing Object Creation</h2>";

try {
    $dbObj = new Database();
    echo "<p><strong>Success:</strong> Database object created.</p>";
} catch (Exception $e) {
    echo "<p><strong>Error:</strong> Could not create Database object: " . $e->getMessage() . "</p>";
}

try {
    $termObj = new Term();
    echo "<p><strong>Success:</strong> Term object created.</p>";
    
    // Test a method
    $terms = $termObj->getAll();
    echo "<p>Found " . count($terms) . " terms in database.</p>";
} catch (Exception $e) {
    echo "<p><strong>Error:</strong> Could not create Term object: " . $e->getMessage() . "</p>";
}

echo "<h2>Include Files</h2>";
echo "<pre>";
print_r(get_included_files());
echo "</pre>";
