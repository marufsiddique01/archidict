<?php
/**
 * Initialization File for Frontend
 * 
 * Loads all required files, starts session, and sets up constants
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load required files first
require_once dirname(__FILE__) . '/config.php';

// Start session
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_name(SESSION_NAME);
    session_start([
        'cookie_lifetime' => SESSION_LIFETIME,
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Strict'
    ]);
}

// Load remaining required files
require_once dirname(__FILE__) . '/database.php';
require_once dirname(__FILE__) . '/utils.php';
require_once dirname(__FILE__) . '/term.php';
require_once dirname(__FILE__) . '/newsletter.php';
?>
