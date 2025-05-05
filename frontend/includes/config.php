<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Database Configuration
 */
// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Replace with your MySQL username if different
define('DB_PASS', '');           // Replace with your MySQL password if needed
define('DB_NAME', 'archidict');

// Application Settings
define('SITE_NAME', 'ArchiDict');
define('SITE_URL', 'http://localhost/archidict/');
define('FRONTEND_URL', SITE_URL . 'frontend/');
define('ADMIN_URL', SITE_URL . 'admin/');
define('UPLOADS_URL', SITE_URL . 'uploads/');

// Uploads Paths
define('UPLOADS_PATH', dirname(__FILE__) . '/../../uploads/');
define('TERMS_UPLOADS', UPLOADS_PATH . 'terms/');
define('NEWSLETTER_UPLOADS', UPLOADS_PATH . 'newsletters/');

// Session Configuration
define('SESSION_NAME', 'archidict_session');
define('SESSION_LIFETIME', 24 * 60 * 60); // 24 hours
