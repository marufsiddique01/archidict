<?php
/**
 * Search Page
 */

// Include initialization file
require_once __DIR__ . '/includes/init.php';

// Create Term instance
$termObj = new Term();

// Check if search query is provided
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if (!empty($searchQuery)) {
    // Perform search
    $results = $termObj->search($searchQuery);
}

// Set page information
$currentPage = 'search';
$pageTitle = 'Search Results';
$pageHeader = 'Search Results';
$pageDescription = !empty($searchQuery) ? 'Results for "' . htmlspecialchars($searchQuery) . '"' : 'Search for architectural terms';

// Include header template
include __DIR__ . '/includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <!-- Search Form -->
        <div class="card border-0 shadow mb-4">
            <div class="card-body p-4">
                <form action="<?php echo FRONTEND_URL; ?>search.php" method="get">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" name="q" placeholder="Search for terms..." 
                               value="<?php echo htmlspecialchars($searchQuery); ?>" required>
                        <button type="submit" class="btn btn-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if (!empty($searchQuery)): ?>
            <!-- Search Results -->
            <div class="card border-0 shadow">
                <div class="card-body p-4">
                    <h5 class="mb-4"><?php echo count($results); ?> result(s) found for "<?php echo htmlspecialchars($searchQuery); ?>"</h5>
                    
                    <?php if (count($results) > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($results as $result): ?>
                                <div class="list-group-item bg-transparent px-0 py-4 border-bottom">
                                    <h4 class="mb-2">
                                        <a href="<?php echo FRONTEND_URL . 'term.php?slug=' . htmlspecialchars($result['slug']); ?>" 
                                           class="text-decoration-none">
                                            <?php echo htmlspecialchars($result['name']); ?>
                                        </a>
                                    </h4>
                                    <p class="text-muted mb-2">
                                        <?php 
                                        // Strip HTML tags and limit the definition to 200 characters
                                        $definition = strip_tags($result['definition']);
                                        echo strlen($definition) > 200 ? substr($definition, 0, 200) . '...' : $definition; 
                                        ?>
                                    </p>
                                    <a href="<?php echo FRONTEND_URL . 'term.php?slug=' . htmlspecialchars($result['slug']); ?>" 
                                       class="btn btn-sm btn-outline-dark">
                                        View Definition
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No results found for "<?php echo htmlspecialchars($searchQuery); ?>".
                            <br><br>
                            Suggestions:
                            <ul>
                                <li>Check your spelling</li>
                                <li>Try more general keywords</li>
                                <li>Try different keywords</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Please enter a search term to find architectural definitions.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Include footer template
include __DIR__ . '/includes/footer.php';
?>
