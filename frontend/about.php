<?php
/**
 * About Page
 */

// Include initialization file
require_once 'includes/init.php';

// Set page information
$currentPage = 'about';
$pageTitle = 'About';
$pageHeader = 'About ArchiDict';
$pageDescription = 'Learn more about our architecture dictionary project.';

// Include header template
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <h2 class="mb-4">Our Mission</h2>
                <p class="lead">To create a comprehensive architecture dictionary that serves as a valuable educational resource for students, professionals, and enthusiasts in the field of architecture.</p>
                
                <p>ArchiDict was established with the aim of providing clear, concise, and accessible definitions of architectural terms, concepts, and principles. Our mission is to:</p>
                
                <ul>
                    <li>Create an authoritative reference resource for architectural terminology</li>
                    <li>Make architectural knowledge more accessible to a broader audience</li>
                    <li>Support architectural education through easy-to-understand definitions</li>
                    <li>Preserve and promote understanding of architectural heritage and concepts</li>
                </ul>
                
                <h2 class="mb-4 mt-5">About the Dictionary</h2>
                <p>ArchiDict features:</p>
                
                <ul>
                    <li>Comprehensive definitions of architectural terms</li>
                    <li>High-quality images to illustrate concepts</li>
                    <li>Cross-references to related terms</li>
                    <li>User-friendly interface with intuitive navigation</li>
                    <li>Regular updates with new terms and expanding content</li>
                </ul>
                
                <h2 class="mb-4 mt-5">Our Team</h2>
                <p>ArchiDict is curated and maintained by a team of architects, architectural historians, and educators passionate about sharing architectural knowledge. Our contributors include:</p>
                
                <ul>
                    <li>Practicing professional architects</li>
                    <li>Architecture professors and educators</li>
                    <li>Architectural historians and researchers</li>
                    <li>Digital content specialists</li>
                </ul>
                
                <h2 class="mb-4 mt-5">Contact Us</h2>
                <p>We welcome your feedback, suggestions, and contributions to help improve ArchiDict:</p>
                
                <ul>
                    <li>Email: <a href="mailto:info@archidict.com">info@archidict.com</a></li>
                    <li>Phone: (123) 456-7890</li>
                    <li>Address: 123 Architecture Ave, Design City</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mt-4 mt-md-0">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h4 class="mb-3">Quick Stats</h4>
                
                <?php
                // Create Term instance
                $termObj = new Term();
                $newsletterObj = new Newsletter();
                
                // Get total counts
                $termCount = $termObj->getTotalCount();
                $newsletterCount = $newsletterObj->getTotalCount();
                ?>
                
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="text-center">
                            <div class="display-4"><?php echo $termCount; ?></div>
                            <div class="text-muted">Total Terms</div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="text-center">
                            <div class="display-4"><?php echo $newsletterCount; ?></div>
                            <div class="text-muted">Newsletters</div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="<?php echo FRONTEND_URL; ?>dictionary.php" class="btn btn-dark">Browse Dictionary</a>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow">
            <div class="card-body">
                <h4 class="mb-3">Our Resources</h4>
                <p>ArchiDict regularly publishes newsletters covering various aspects of architecture. These newsletters provide additional context and insights beyond our dictionary entries.</p>
                <div class="mt-3">
                    <a href="<?php echo FRONTEND_URL; ?>newsletters.php" class="btn btn-outline-dark">View Newsletters</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer template
include 'includes/footer.php';
?>
