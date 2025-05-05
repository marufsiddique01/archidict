<?php
/**
 * Newsletters Page
 */

// Include initialization file
require_once 'includes/init.php';

// Create Newsletter instance
$newsletterObj = new Newsletter();

// Get all newsletters
$newsletters = $newsletterObj->getAll();

// Set page information
$currentPage = 'newsletters';
$pageTitle = 'Newsletters';
$pageHeader = 'Architecture Newsletters';
$pageDescription = 'Access our collection of architecture newsletters with the latest trends, features, and resources.';

// Include header template
include 'includes/header.php';
?>

<div class="row">
    <?php if (count($newsletters) > 0): ?>
        <?php foreach ($newsletters as $newsletter): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="newsletter-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h4><?php echo htmlspecialchars($newsletter['title']); ?></h4>
                        <p class="text-muted">Published on <?php echo Utils::formatDate($newsletter['created_at'], 'F d, Y'); ?></p>
                        
                        <?php if (!empty($newsletter['description'])): ?>
                            <p class="flex-grow-1"><?php echo htmlspecialchars($newsletter['description']); ?></p>
                        <?php else: ?>
                            <div class="flex-grow-1"></div>
                        <?php endif; ?>
                        
                        <div class="mt-3">
                            <a href="<?php echo UPLOADS_URL . 'newsletters/' . htmlspecialchars($newsletter['file_path']); ?>" 
                               class="btn btn-download" download>
                                <i class="fas fa-download me-2"></i> Download Newsletter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                No newsletters available at the moment. Please check back later.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
// Include footer template
include 'includes/footer.php';
?>
