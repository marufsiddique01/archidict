<?php
// Simple test page with no dependencies
echo "<h1>ArchiDict Test Page</h1>";
echo "<p>If you can see this, PHP is working correctly on your server.</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP version: " . phpversion() . "</p>";

// Show error reporting settings
echo "<h2>Error Reporting</h2>";
echo "display_errors: " . ini_get('display_errors') . "<br>";
echo "error_reporting: " . ini_get('error_reporting') . "<br>";

// Show some server info
echo "<h2>Server Info</h2>";
echo "SERVER_SOFTWARE: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";

// Show PHP execution info
echo "<h2>PHP Info</h2>";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";

// Links to other test pages
echo "<h2>Test Links</h2>";
echo "<a href='test.php'>PHP Info</a><br>";
echo "<a href='phpinfo_check.php'>PHP Configuration Check</a><br>";
echo "<a href='dbtest.php'>Database Test</a><br>";
echo "<a href='setup_db.php'>Setup Database</a><br>";
echo "<a href='admin/login.php'>Admin Login</a><br>";
?>
