<?php
/**
 * Terms Index Page
 */
// Page title
$pageTitle = 'Manage Terms';

// Include initialization file
require_once '../includes/config.php';
require_once '../includes/init.php';

// Require user to be logged in
requireLogin();

// Create Term instance
$termObj = new Term();

// Handle search
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = Utils::sanitize($_GET['search']);
    $terms = $termObj->search($search);
} else {
    // Get all terms
    $terms = $termObj->getAll();
}

// Include header template
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Terms</h1>
    <a href="add.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Add New Term
    </a>
</div>

<!-- Search form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="" class="row g-3">
            <div class="col-md-10">
                <input type="text" class="form-control" id="search" name="search" placeholder="Search terms..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<!-- Terms list -->
<div class="card">
    <div class="card-header">
        <h5>Terms List</h5>
    </div>
    <div class="card-body">
        <?php if (count($terms) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($terms as $term): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($term['name']); ?></td>
                                <td><?php echo htmlspecialchars($term['slug']); ?></td>
                                <td>
                                    <?php if (!empty($term['image'])): ?>
                                        <img src="<?php echo UPLOADS_URL . 'terms/' . htmlspecialchars($term['image']); ?>" alt="<?php echo htmlspecialchars($term['name']); ?>" width="50">
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo Utils::formatDate($term['created_at'], 'M d, Y H:i'); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $term['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $term['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this term?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No terms found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Include footer template
include '../includes/footer.php';
?>
