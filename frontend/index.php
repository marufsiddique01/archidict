<?php
/**
 * Main index file for ArchiDict Frontend
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to handle fatal errors gracefully
function handleFatalErrors() {
    $error = error_get_last();
    if ($error && ($error['type'] === E_ERROR || $error['type'] === E_PARSE)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error - ArchiDict</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <div class="container py-5">
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h1 class="h4 mb-0">Application Error</h1>
                    </div>
                    <div class="card-body">
                        <p>Sorry, we encountered a problem loading this page. Our team has been notified.</p>
                        <p><strong>Error details:</strong> ' . htmlspecialchars($error['message']) . ' in ' . htmlspecialchars($error['file']) . ' on line ' . $error['line'] . '</p>
                        <hr>
                        <a href="../index.php" class="btn btn-primary">Return to Home</a>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        exit;
    }
}

// Register shutdown function to catch fatal errors
register_shutdown_function('handleFatalErrors');

try {
    // Include initialization file
    require_once __DIR__ . '/includes/init.php';
    
    // Create instances
    $termObj = new Term();
    $newsletterObj = new Newsletter();
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error - ArchiDict</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <div class="card border-danger shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h1 class="h4 mb-0">Application Error</h1>
                </div>
                <div class="card-body">
                    <p>Sorry, we encountered a problem loading this page. Our team has been notified.</p>
                    <p><strong>Error details:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
                    <hr>
                    <a href="../index.php" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

// Get featured terms (random selection)
$featuredTerms = $termObj->getRandomTerms(6);

// Get latest newsletters
$latestNewsletters = $newsletterObj->getLatest(3);

// Set page information
$currentPage = 'home';
$pageTitle = 'Home';

// Include header template
include __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="card h-100 border-0 shadow">
            <div class="card-body p-5">
                <h1 class="display-4 mb-4">Architecture Dictionary</h1>
                <p class="lead">Explore the comprehensive collection of architecture terms, definitions, and concepts. A valuable resource for students, professionals, and enthusiasts.</p>                <div class="mt-4">
                    <a href="<?php echo FRONTEND_URL; ?>dictionary.php" class="btn btn-lg btn-dark me-2">Browse Dictionary</a>
                    <a href="<?php echo FRONTEND_URL; ?>newsletters.php" class="btn btn-lg btn-outline-secondary">View Newsletters</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow">
            <div class="card-body p-4">
                <h3 class="mb-4">Quick Search</h3>
                
                <!-- Alphabet Navigation -->
                <div class="alphabet-nav text-center">
                    <?php
                    $availableLetters = $termObj->getAvailableLetters();
                    foreach (range('A', 'Z') as $letter):
                        $isAvailable = in_array($letter, $availableLetters);
                        $linkClass = $isAvailable ? 'letter' : 'letter disabled';
                    ?>                        <a href="<?php echo $isAvailable ? FRONTEND_URL . 'dictionary.php?letter=' . $letter : '#'; ?>" 
                           class="<?php echo $linkClass; ?>"
                           <?php echo !$isAvailable ? 'aria-disabled="true"' : ''; ?>>
                            <?php echo $letter; ?>
                        </a>
                    <?php endforeach; ?>
                      <?php if (in_array('#', $availableLetters)): ?>
                        <a href="<?php echo FRONTEND_URL; ?>dictionary.php?letter=%23" class="letter">#</a>
                    <?php else: ?>
                        <a href="#" class="letter disabled" aria-disabled="true">#</a>
                    <?php endif; ?>
                </div>
                  <!-- Search Form -->
                <form action="<?php echo FRONTEND_URL; ?>search.php" method="get" class="mt-4">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="q" placeholder="Search for terms...">
                        <button type="submit" class="btn btn-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Featured Terms -->
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-4">Featured Terms</h2>
    </div>
    
    <?php foreach ($featuredTerms as $term): ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <?php if (!empty($term['image'])): ?>
            <img src="<?php echo UPLOADS_URL . 'terms/' . htmlspecialchars($term['image']); ?>" 
                 class="card-img-top" alt="<?php echo htmlspecialchars($term['name']); ?>">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($term['name']); ?></h5>
                <p class="card-text">
                    <?php 
                    // Strip HTML tags and limit to 100 characters
                    $definition = strip_tags($term['definition']);
                    echo strlen($definition) > 100 ? substr($definition, 0, 100) . '...' : $definition; 
                    ?>
                </p>
                <a href="<?php echo FRONTEND_URL . 'term.php?slug=' . htmlspecialchars($term['slug']); ?>" class="btn btn-sm btn-outline-dark">Read More</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
      <div class="col-12 mt-3 text-center">
        <a href="<?php echo FRONTEND_URL; ?>dictionary.php" class="btn btn-dark">View All Terms</a>
    </div>
</div>

<!-- Latest Newsletters -->
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Latest Newsletters</h2>
    </div>
    
    <?php if (count($latestNewsletters) > 0): ?>
        <?php foreach ($latestNewsletters as $newsletter): ?>
        <div class="col-md-4 mb-4">
            <div class="newsletter-card">
                <div class="card-body">
                    <h5><?php echo htmlspecialchars($newsletter['title']); ?></h5>
                    <p class="text-muted"><?php echo Utils::formatDate($newsletter['created_at'], 'F d, Y'); ?></p>
                    <?php if (!empty($newsletter['description'])): ?>
                    <p><?php echo htmlspecialchars($newsletter['description']); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo UPLOADS_URL . 'newsletters/' . htmlspecialchars($newsletter['file_path']); ?>" 
                       class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i> Download
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
          <div class="col-12 text-center mt-3">
            <a href="<?php echo FRONTEND_URL; ?>newsletters.php" class="btn btn-outline-dark">View All Newsletters</a>
        </div>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                No newsletters available at the moment.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
// Include footer template
include __DIR__ . '/includes/footer.php';
?>
