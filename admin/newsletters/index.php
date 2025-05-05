<?php
/**
 * Newsletters Index Page
 */
// Page title
$pageTitle = 'Manage Newsletters';

// Include initialization file
require_once '../includes/config.php';
require_once '../includes/init.php';

// Require user to be logged in
requireLogin();

// Create Newsletter instance
$newsletterObj = new Newsletter();

// Handle search
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = Utils::sanitize($_GET['search']);
    $newsletters = $newsletterObj->search($search);
} else {
    // Get all newsletters
    $newsletters = $newsletterObj->getAll();
}

// Include header template
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Newsletters</h1>
    <a href="add.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Add New Newsletter
    </a>
</div>

<!-- Search form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="" class="row g-3">
            <div class="col-md-10">
                <input type="text" class="form-control" id="search" name="search" placeholder="Search newsletters..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<!-- Newsletters list -->
<div class="card">
    <div class="card-header">
        <h5>Newsletters List</h5>
    </div>
    <div class="card-body">
        <?php if (count($newsletters) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>File</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($newsletters as $newsletter): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($newsletter['title']); ?></td>
                                <td>
                                    <a href="<?php echo UPLOADS_URL . 'newsletters/' . htmlspecialchars($newsletter['file_path']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($newsletter['file_path']); ?>
                                    </a>
                                </td>
                                <td><?php echo Utils::formatDate($newsletter['created_at'], 'M d, Y H:i'); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $newsletter['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $newsletter['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this newsletter?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No newsletters found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Include footer template
include '../includes/footer.php';
?>
