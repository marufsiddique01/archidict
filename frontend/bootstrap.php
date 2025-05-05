<?php
/**
 * Bootstrap file for ArchiDict Frontend
 * 
 * This file ensures that all necessary classes are loaded properly
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the absolute path to the frontend directory
define('FRONTEND_DIR', __DIR__);

// Include configuration file
require_once FRONTEND_DIR . '/includes/config.php';

// Include database class
require_once FRONTEND_DIR . '/includes/database.php';

// Include utility functions
require_once FRONTEND_DIR . '/includes/utils.php';

// Include main classes
require_once FRONTEND_DIR . '/includes/term.php';
require_once FRONTEND_DIR . '/includes/newsletter.php';

// Start session only if it hasn't been started yet and no output has been sent
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_name(SESSION_NAME);
    session_start([
        'cookie_lifetime' => SESSION_LIFETIME,
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Strict'
    ]);
}

// Function to check if classes exist
function checkClasses() {
    $classes = [
        'Database',
        'Term',
        'Newsletter',
        'Utils'
    ];
    
    $missing = [];
    foreach ($classes as $class) {
        if (!class_exists($class)) {
            $missing[] = $class;
        }
    }
    
    return empty($missing);
}

// We don't automatically run the check to avoid output
// that might interfere with headers
