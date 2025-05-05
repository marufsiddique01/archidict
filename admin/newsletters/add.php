<?php
/**
 * Add Newsletter Page
 */
// Page title
$pageTitle = 'Add New Newsletter';

// Include initialization file
require_once '../includes/config.php';
require_once '../includes/init.php';

// Require user to be logged in
requireLogin();

// Create Newsletter instance
$newsletterObj = new Newsletter();

// Initialize variables
$title = '';
$description = '';
$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = Utils::sanitize($_POST['title'] ?? '');
    $description = Utils::sanitize($_POST['description'] ?? '');
    
    // Validate input
    if (empty($title)) {
        $message = 'Newsletter title is required.';
        $messageType = 'danger';
    } elseif (!isset($_FILES['newsletter_file']) || $_FILES['newsletter_file']['error'] === UPLOAD_ERR_NO_FILE) {
        $message = 'Newsletter file is required.';
        $messageType = 'danger';
    } else {
        // Process file upload
        $fileValidation = Utils::validatePdfUpload($_FILES['newsletter_file']);
        
        if ($fileValidation['success']) {
            // Generate unique filename
            $filename = Utils::generateUniqueFilename($_FILES['newsletter_file']['name']);
            $targetPath = NEWSLETTER_UPLOADS . $filename;
            
            // Move the uploaded file
            if (move_uploaded_file($_FILES['newsletter_file']['tmp_name'], $targetPath)) {
                // Create newsletter
                $newsletterData = [
                    'title' => $title,
                    'description' => $description,
                    'file_path' => $filename
                ];
                
                $result = $newsletterObj->create($newsletterData);
                
                if (is_numeric($result)) {
                    // Set success message
                    $_SESSION['message'] = 'Newsletter created successfully.';
                    $_SESSION['message_type'] = 'success';
                    
                    // Redirect to newsletters list
                    header('Location: index.php');
                    exit;
                } else {
                    $message = $result;
                    $messageType = 'danger';
                }
            } else {
                $message = 'Failed to upload file.';
                $messageType = 'danger';
            }
        } else {
            $message = $fileValidation['message'];
            $messageType = 'danger';
        }
    }
}

// Include header template
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Add New Newsletter</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Newsletters
    </a>
</div>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Newsletter Title *</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="newsletter_file" class="form-label">PDF File *</label>
                <input type="file" class="form-control" id="newsletter_file" name="newsletter_file" accept=".pdf" required>
                <div class="form-text">Maximum file size: 5 MB. Only PDF files are allowed.</div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Newsletter</button>
                <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
// Include footer template
include '../includes/footer.php';
?>
