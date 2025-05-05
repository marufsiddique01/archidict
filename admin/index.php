<?php
/**
 * Admin Dashboard Index Page
 */
// Page title
$pageTitle = 'Dashboard';

// Include initialization file
require_once 'includes/config.php';
require_once 'includes/init.php';

// Require user to be logged in
requireLogin();

// Create instances for dashboard stats
$termObj = new Term();
$newsletterObj = new Newsletter();

// Get all terms
$terms = $termObj->getAll();
$termCount = count($terms);

// Get all newsletters
$newsletters = $newsletterObj->getAll();
$newsletterCount = count($newsletters);

// Include header template
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Dashboard</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <i class="fas fa-book dashboard-icon mb-3"></i>
                <h3><?php echo $termCount; ?></h3>
                <h5>Total Terms</h5>
                <a href="<?php echo ADMIN_URL; ?>terms/index.php" class="btn btn-outline-primary mt-3">Manage Terms</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <i class="fas fa-newspaper dashboard-icon mb-3"></i>
                <h3><?php echo $newsletterCount; ?></h3>
                <h5>Total Newsletters</h5>
                <a href="<?php echo ADMIN_URL; ?>newsletters/index.php" class="btn btn-outline-primary mt-3">Manage Newsletters</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Recent Terms</h5>
            </div>
            <div class="card-body">
                <?php if ($termCount > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($terms, 0, 5) as $term): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($term['name']); ?></td>
                                        <td><?php echo htmlspecialchars($term['slug']); ?></td>
                                        <td><?php echo Utils::formatDate($term['created_at'], 'M d, Y H:i'); ?></td>
                                        <td>
                                            <a href="<?php echo ADMIN_URL; ?>terms/edit.php?id=<?php echo $term['id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
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
    </div>
</div>

<?php
// Include footer template
include 'includes/footer.php';
?>
