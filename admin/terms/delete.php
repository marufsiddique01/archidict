<?php
/**
 * Delete Term Page
 */
// Include initialization file
require_once '../includes/config.php';
require_once '../includes/init.php';

// Require user to be logged in
requireLogin();

// Create Term instance
$termObj = new Term();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = 'Invalid term ID.';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

$termId = (int)$_GET['id'];

// Get term by ID
$term = $termObj->getById($termId);

if (!$term) {
    $_SESSION['message'] = 'Term not found.';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

// Handle confirmation
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Delete the term
    $result = $termObj->delete($termId);
    
    if ($result === true) {
        $_SESSION['message'] = 'Term deleted successfully.';
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
$pageTitle = 'Delete Term';

// Include header template
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Delete Term</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Terms
    </a>
</div>

<div class="card">
    <div class="card-body">
        <p>Are you sure you want to delete the term <strong><?php echo htmlspecialchars($term['name']); ?></strong>?</p>
        <p>This action cannot be undone. All related information will be permanently deleted.</p>
        
        <div class="mt-4">
            <a href="delete.php?id=<?php echo $termId; ?>&confirm=yes" class="btn btn-danger">Yes, Delete</a>
            <a href="delete.php?id=<?php echo $termId; ?>&confirm=no" class="btn btn-secondary ms-2">No, Cancel</a>
        </div>
    </div>
</div>

<?php
// Include footer template
include '../includes/footer.php';
?>
