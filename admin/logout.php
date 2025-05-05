<?php
/**
 * Admin Logout Page
 */
// Load configuration first
require_once 'includes/config.php';

// Start session after loading configuration
session_name(SESSION_NAME);
session_start([
    'cookie_lifetime' => SESSION_LIFETIME,
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

// Load remaining required files
require_once 'includes/database.php';
require_once 'includes/utils.php';
require_once 'includes/auth.php';

// Create Auth instance
$auth = new Auth();

// Log the user out
$auth->logout();

// Redirect to login page with message
$_SESSION['message'] = 'You have been successfully logged out.';
$_SESSION['message_type'] = 'success';

header('Location: login.php');
exit;
