<?php
/**
 * Add Term Page
 */
// Page title
$pageTitle = 'Add New Term';

// Include initialization file
require_once '../includes/config.php';
require_once '../includes/init.php';

// Require user to be logged in
requireLogin();

// Create Term instance
$termObj = new Term();

// Get all terms for relationship selection
$allTerms = $termObj->getAll();

// Initialize variables
$name = '';
$slug = '';
$definition = '';
$message = '';
$messageType = '';
$relatedTerms = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = Utils::sanitize($_POST['name'] ?? '');
    $slug = Utils::sanitize($_POST['slug'] ?? '');
    $definition = $_POST['definition'] ?? ''; // Don't sanitize WYSIWYG content here
    $relatedTerms = isset($_POST['related_terms']) ? array_map('intval', $_POST['related_terms']) : [];
    
    // Validate input
    if (empty($name)) {
        $message = 'Term name is required.';
        $messageType = 'danger';
    } else {
        // Process image upload if exists
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $imageValidation = Utils::validateImageUpload($_FILES['image']);
            
            if ($imageValidation['success']) {
                // Generate unique filename
                $filename = Utils::generateUniqueFilename($_FILES['image']['name']);
                $targetPath = TERMS_UPLOADS . $filename;
                
                // Move the uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $filename;
                } else {
                    $message = 'Failed to upload image.';
                    $messageType = 'danger';
                }
            } else {
                $message = $imageValidation['message'];
                $messageType = 'danger';
            }
        }
        
        if (empty($message)) {
            // Create term
            $termData = [
                'name' => $name,
                'slug' => $slug,
                'definition' => $definition
            ];
            
            if ($image) {
                $termData['image'] = $image;
            }
            
            $result = $termObj->create($termData);
            
            if (is_numeric($result)) {
                // Term created successfully, now set related terms if any
                if (!empty($relatedTerms)) {
                    $termObj->setRelatedTerms($result, $relatedTerms);
                }
                
                // Set success message
                $_SESSION['message'] = 'Term created successfully.';
                $_SESSION['message_type'] = 'success';
                
                // Redirect to terms list
                header('Location: index.php');
                exit;
            } else {
                $message = $result;
                $messageType = 'danger';
            }
        }
    }
}

// Include header template
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Add New Term</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Terms
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
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Term Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($slug); ?>" aria-describedby="slugHelp">
                        <div id="slugHelp" class="form-text">Leave blank to generate automatically from the term name.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="definition" class="form-label">Definition *</label>
                        <textarea class="form-control tinymce-editor" id="definition" name="definition"><?php echo htmlspecialchars($definition); ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Related Terms</label>
                        <div class="term-relationship-list">
                            <?php if (count($allTerms) > 0): ?>
                                <?php foreach ($allTerms as $term): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="related_terms[]" value="<?php echo $term['id']; ?>" id="term-<?php echo $term['id']; ?>" <?php echo in_array($term['id'], $relatedTerms) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="term-<?php echo $term['id']; ?>">
                                            <?php echo htmlspecialchars($term['name']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No terms available for relationships.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Term</button>
                <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
// Include footer template
include '../includes/footer.php';
?>
