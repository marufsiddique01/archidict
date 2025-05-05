<?php
/**
 * Dictionary page with Turn.js book interface
 */

// Include initialization file
require_once 'includes/init.php';

// Create Term instance
$termObj = new Term();

// Handle letter filtering
$letter = isset($_GET['letter']) ? $_GET['letter'] : null;

// Get terms from database
if ($letter) {
    $terms = $termObj->getTermsByLetter($letter);
    $activeLetterLabel = $letter == '%23' ? '#' : $letter;
    $pageTitle = "Dictionary - Letter $activeLetterLabel";
} else {
    $terms = $termObj->getAll();
    $pageTitle = "Dictionary";
}

// Get available letters for navigation
$availableLetters = $termObj->getAvailableLetters();

// Set page information
$currentPage = 'dictionary';
$pageHeader = 'Architecture Dictionary';
$pageDescription = 'Browse all architecture terms in our comprehensive dictionary.';

// Include header template
include 'includes/header.php';
?>

<!-- Alphabet Navigation -->
<div class="alphabet-nav text-center mb-4">
    <?php
    foreach (range('A', 'Z') as $l):
        $isAvailable = in_array($l, $availableLetters);
        $isActive = $letter == $l;
        $linkClass = $isActive ? 'letter active' : ($isAvailable ? 'letter' : 'letter disabled');
    ?>
        <a href="<?php echo $isAvailable ? SITE_URL . 'dictionary.php?letter=' . $l : '#'; ?>" 
           class="<?php echo $linkClass; ?>"
           <?php echo !$isAvailable ? 'aria-disabled="true"' : ''; ?>>
            <?php echo $l; ?>
        </a>
    <?php endforeach; ?>
    
    <?php 
    $isNumberActive = $letter == '%23';
    $isNumberAvailable = in_array('#', $availableLetters);
    $numberLinkClass = $isNumberActive ? 'letter active' : ($isNumberAvailable ? 'letter' : 'letter disabled');
    ?>
    <a href="<?php echo $isNumberAvailable ? SITE_URL . 'dictionary.php?letter=%23' : '#'; ?>" 
       class="<?php echo $numberLinkClass; ?>"
       <?php echo !$isNumberAvailable ? 'aria-disabled="true"' : ''; ?>>
        #
    </a>
</div>

<?php if (empty($letter)): ?>
<!-- Dictionary Book with Turn.js -->
<div class="row">
    <div class="col-12">
        <div class="dictionary-container shadow">
            <!-- Book container -->
            <div id="dictionary-book">
                <!-- Cover Page -->
                <div class="hard dictionary-cover">
                    <div class="text-center">
                        <h1 class="display-4 mb-4">ArchiDict</h1>
                        <h3 class="mb-3">Architecture Dictionary</h3>
                        <p class="lead">A comprehensive collection of architecture terms and definitions</p>
                    </div>
                </div>
                
                <!-- Back of Cover -->
                <div class="hard">
                    <div class="book-page">
                        <h2>How to Use This Dictionary</h2>
                        <p>This interactive dictionary allows you to browse through architecture terms in a book-like interface:</p>
                        <ul>
                            <li>Click and drag the page corners to flip through the dictionary</li>
                            <li>Use the controls below to navigate between pages</li>
                            <li>Click on any term to view its complete definition</li>
                            <li>Related terms are linked for easy reference</li>
                        </ul>
                        <p>You can also use the alphabet navigation above to filter terms by their first letter.</p>
                        <p class="text-center mt-5"><i class="fas fa-arrow-right fa-2x"></i></p>
                    </div>
                </div>
                
                <?php
                // Group terms by first letter for the book content
                $termsByLetter = $termObj->getTermsByAlphabet();
                
                // Display terms by letter in the book pages
                foreach ($termsByLetter as $firstLetter => $letterTerms):
                ?>
                <!-- Dictionary Pages -->
                <div>
                    <div class="book-page">
                        <h2><?php echo $firstLetter; ?></h2>
                        <ul class="term-list">
                            <?php foreach ($letterTerms as $term): ?>
                                <li class="term-item">
                                    <a href="<?php echo SITE_URL . 'term.php?slug=' . htmlspecialchars($term['slug']); ?>" class="term-link">
                                        <?php echo htmlspecialchars($term['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <!-- Back Cover (last page) -->
                <div class="hard">
                    <div class="book-page">
                        <div class="text-center h-100 d-flex flex-column justify-content-center align-items-center">
                            <h2>ArchiDict</h2>
                            <p class="lead">Thank you for exploring our architecture dictionary</p>
                            <p class="mt-4">© <?php echo date('Y'); ?> ArchiDict</p>
                        </div>
                    </div>
                </div>
                
                <!-- Back Cover -->
                <div class="hard dictionary-cover">
                    <div class="text-center">
                        <h2>Architecture Dictionary</h2>
                    </div>
                </div>
            </div>
            
            <!-- Book Controls -->
            <div class="book-controls mb-4">
                <button id="prev-btn" class="btn-prev" onclick="prevPage()"><i class="fas fa-chevron-left"></i> Previous</button>
                <button id="next-btn" class="btn-next" onclick="nextPage()">Next <i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Letter-filtered view (traditional list) -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h2>Terms starting with "<?php echo $letter == '%23' ? '#' : $letter; ?>"</h2>
                
                <?php if (count($terms) > 0): ?>
                <ul class="term-list mt-4">
                    <?php foreach ($terms as $term): ?>
                    <li class="term-item py-2">
                        <a href="<?php echo SITE_URL . 'term.php?slug=' . htmlspecialchars($term['slug']); ?>" class="term-link">
                            <h5><?php echo htmlspecialchars($term['name']); ?></h5>
                        </a>
                        <p class="text-muted">
                            <?php 
                            // Strip HTML tags and limit to 150 characters
                            $definition = strip_tags($term['definition']);
                            echo strlen($definition) > 150 ? substr($definition, 0, 150) . '...' : $definition; 
                            ?>
                        </p>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="alert alert-info">
                    No terms found starting with "<?php echo $letter == '%23' ? '#' : $letter; ?>".
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- JavaScript for Turn.js -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Turn.js only if we're on the main dictionary view
    if (document.getElementById('dictionary-book')) {
        $('#dictionary-book').turn({
            width: Math.min(1000, window.innerWidth * 0.9),
            height: 600,
            autoCenter: true,
            gradients: true,
            acceleration: true
        });
    }
});

// Navigation functions
function prevPage() {
    $('#dictionary-book').turn('previous');
}

function nextPage() {
    $('#dictionary-book').turn('next');
}

// Handle window resize
window.addEventListener('resize', function() {
    if (document.getElementById('dictionary-book')) {
        $('#dictionary-book').turn('size', 
            Math.min(1000, window.innerWidth * 0.9),
            600
        );
    }
});
</script>

<?php
// Include footer template
include 'includes/footer.php';
?>
