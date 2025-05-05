<?php
/**
 * Initialization File for Frontend
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
require_once 'term.php';
require_once 'newsletter.php';
?>
