<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Redirect to admin login page
    header('Location: admin/login.php');
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
