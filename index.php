<?php
/**
 * Main index file for ArchiDict
 * Provides navigation to both Frontend and Admin areas
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Basic site configuration
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/archidict/');
define('FRONTEND_URL', SITE_URL . 'frontend/');
define('ADMIN_URL', SITE_URL . 'admin/');

// Handle redirects for old URLs (in case .htaccess isn't working)
$redirect_map = [
    '/dictionary.php' => 'frontend/dictionary.php',
    '/term.php' => 'frontend/term.php',
    '/search.php' => 'frontend/search.php',
    '/newsletters.php' => 'frontend/newsletters.php',
    '/about.php' => 'frontend/about.php'
];

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$script_name = basename($request_uri);

if (array_key_exists($script_name, $redirect_map)) {
    header('Location: ' . SITE_URL . $redirect_map[$script_name] . (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
    exit;
}

// Set page information
$pageTitle = 'Welcome to ArchiDict';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | ArchiDict</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 2rem;
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .area-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }
        .btn-custom {
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 50px;
        }
        .section-title {
            margin-bottom: 3rem;
            position: relative;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #212529;
        }
        .site-header {
            margin-bottom: 4rem;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="site-header text-center">
        <h1 class="display-4 mb-3">Architecture Dictionary</h1>
        <p class="lead text-muted">Explore architectural terms, concepts, and knowledge resources</p>
    </header>
<?php
// Continue with the rest of the page...
?>

    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="section-title">Select an Area to Access</h2>
        </div>
        
        <!-- Frontend Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow">
                <div class="card-body p-5 text-center">
                    <div class="area-icon text-primary">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="mb-3">Dictionary Frontend</h3>
                    <p class="text-muted mb-4">Browse architectural terms, search the dictionary, read definitions, and access newsletters.</p>
                    <div class="d-grid">
                        <a href="<?php echo FRONTEND_URL; ?>" class="btn btn-lg btn-primary btn-custom">
                            Enter Dictionary <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-light p-3">
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-search me-2"></i> Search Dictionary</span>
                        <span><i class="fas fa-newspaper me-2"></i> Newsletters</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Admin Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow">
                <div class="card-body p-5 text-center">
                    <div class="area-icon text-danger">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="mb-3">Admin Dashboard</h3>
                    <p class="text-muted mb-4">Manage dictionary terms, upload newsletters, and control website content.</p>
                    <div class="d-grid">
                        <a href="<?php echo ADMIN_URL; ?>" class="btn btn-lg btn-danger btn-custom">
                            Access Admin <i class="fas fa-lock ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-light p-3">
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-edit me-2"></i> Manage Terms</span>
                        <span><i class="fas fa-cog me-2"></i> Settings</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i> About ArchiDict</h4>
                    <p>ArchiDict is a comprehensive architecture dictionary resource designed for students, educators, professionals, and enthusiasts. The platform offers detailed definitions, images, and resources related to architectural terms and concepts.</p>
                    <p class="mb-0">This landing page provides access to both the public dictionary interface and the secure admin dashboard for managing content.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-5 py-4 text-center text-muted">
    <div class="container">
        <p>ArchiDict - Architecture Dictionary &copy; <?php echo date('Y'); ?></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
