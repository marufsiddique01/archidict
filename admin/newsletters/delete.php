<?php
/**
 * Delete Newsletter Page
 */
// Include initialization file
require_once '../includes/config.php';
require_once '../includes/init.php';

// Require user to be logged in
requireLogin();

// Create Newsletter instance
$newsletterObj = new Newsletter();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = 'Invalid newsletter ID.';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

$newsletterId = (int)$_GET['id'];

// Get newsletter by ID
$newsletter = $newsletterObj->getById($newsletterId);

if (!$newsletter) {
    $_SESSION['message'] = 'Newsletter not found.';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

// Handle confirmation
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Delete the newsletter
    $result = $newsletterObj->delete($newsletterId);
    
    if ($result === true) {
        $_SESSION['message'] = 'Newsletter deleted successfully.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = $result;
        $_SESSION['message_type'] = 'danger';
    }
    
    header('Location: index.php');
    exit;
} elseif (isset($_GET['confirm']) && $_GET['confirm'] === 'no') {
    // Cancel deletion
    header('Location: index.php');
    exit;
}

// Set page title
$pageTitle = 'Delete Newsletter';

// Include header template
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Delete Newsletter</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Newsletters
    </a>
</div>

<div class="card">
    <div class="card-body">
        <p>Are you sure you want to delete the newsletter <strong><?php echo htmlspecialchars($newsletter['title']); ?></strong>?</p>
        <p>This action cannot be undone. The newsletter file will also be permanently deleted.</p>
        
        <div class="mt-4">
            <a href="delete.php?id=<?php echo $newsletterId; ?>&confirm=yes" class="btn btn-danger">Yes, Delete</a>
            <a href="delete.php?id=<?php echo $newsletterId; ?>&confirm=no" class="btn btn-secondary ms-2">No, Cancel</a>
        </div>
    </div>
</div>

<?php
// Include footer template
include '../includes/footer.php';
?>
