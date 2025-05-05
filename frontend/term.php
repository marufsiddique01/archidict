<?php
/**
 * Term Detail Page
 */

// Include initialization file
require_once 'includes/init.php';

// Create Term instance
$termObj = new Term();

// Check if slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header('Location: dictionary.php');
    exit;
}

$slug = $_GET['slug'];

// Get term by slug
$term = $termObj->getBySlug($slug);

if (!$term) {
    // Term not found, redirect to dictionary
    header('Location: dictionary.php');
    exit;
}

// Get related terms
$relatedTerms = $termObj->getRelatedTermsWithDetails($term['id']);

// Set page information
$currentPage = 'dictionary';
$pageTitle = $term['name'];

// Include header template
include 'includes/header.php';
?>

<div class="row">
    <div class="col-12 mb-4">
        <a href="<?php echo FRONTEND_URL; ?>dictionary.php" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-2"></i> Back to Dictionary
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="term-definition">
                    <h1 class="mb-4"><?php echo htmlspecialchars($term['name']); ?></h1>
                    
                    <?php if (!empty($term['image'])): ?>
                        <div class="term-image mb-4">
                            <img src="<?php echo UPLOADS_URL . 'terms/' . htmlspecialchars($term['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($term['name']); ?>"
                                 class="img-fluid rounded">
                        </div>
                    <?php endif; ?>
                    
                    <div class="definition-content">
                        <?php echo $term['definition']; ?>
                    </div>
                    
                    <?php if (count($relatedTerms) > 0): ?>
                        <div class="related-terms mt-5">
                            <h4>Related Terms</h4>
                            <div>
                                <?php foreach ($relatedTerms as $relatedTerm): ?>
                                    <a href="<?php echo FRONTEND_URL . 'term.php?slug=' . htmlspecialchars($relatedTerm['slug']); ?>" class="term-link">
                                        <?php echo htmlspecialchars($relatedTerm['name']); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mt-4 mt-md-0">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h4 class="mb-3">Quick Navigation</h4>
                
                <!-- Alphabet Navigation -->
                <div class="alphabet-nav">
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
            </div>
        </div>
        
        <!-- Random Terms -->
        <div class="card border-0 shadow">
            <div class="card-body">
                <h4 class="mb-3">Explore More Terms</h4>
                <ul class="list-group list-group-flush">
                    <?php 
                    $randomTerms = $termObj->getRandomTerms(5);
                    foreach ($randomTerms as $randomTerm):
                        // Skip the current term
                        if ($randomTerm['id'] == $term['id']) continue;
                    ?>
                        <li class="list-group-item bg-transparent px-0">
                            <a href="<?php echo FRONTEND_URL . 'term.php?slug=' . htmlspecialchars($randomTerm['slug']); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($randomTerm['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mt-3">
                    <a href="<?php echo FRONTEND_URL; ?>dictionary.php" class="btn btn-sm btn-dark">View All Terms</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer template
include 'includes/footer.php';
?>
