<?php
/**
 * Initialization File
 * 
 * Loads all required files, starts session, and sets up constants
 */

// Load required files first
require_once 'config.php';

// Start session
session_name(SESSION_NAME);
session_start([
    'cookie_lifetime' => SESSION_LIFETIME,
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

// Load remaining required files
require_once 'database.php';
require_once 'utils.php';
require_once 'auth.php';
require_once 'term.php';
require_once 'newsletter.php';

// Create instances for common use
$auth = new Auth();
$utils = new Utils();

// Check if user is authenticated for protected pages
function requireLogin() {
    global $auth;
    
    if (!$auth->isLoggedIn()) {
        header('Location: ' . ADMIN_URL . 'login.php');
        exit;
    }
}
