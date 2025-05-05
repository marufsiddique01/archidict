<?php
/**
 * Header Template for Frontend
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Turn.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>js/turn.min.js"></script>
    
    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="site-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <a href="<?php echo SITE_URL; ?>" class="site-logo text-decoration-none">ArchiDict</a>
                    <p class="text-muted mb-0">Architecture Dictionary</p>
                </div>
                <div class="col-md-6">
                    <form action="<?php echo SITE_URL; ?>search.php" method="get" class="search-form">
                        <input type="text" name="q" placeholder="Search for terms..." 
                            value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="main-navigation">
            <div class="container">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'home' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'dictionary' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>dictionary.php">Dictionary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'newsletters' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>newsletters.php">Newsletters</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'about' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>about.php">About</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <!-- Main Content -->
    <main class="main-content py-5">
        <div class="container"><?php if (!empty($pageHeader)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="page-title"><?php echo $pageHeader; ?></h1>
                    <?php if (!empty($pageDescription)): ?>
                    <p class="text-muted"><?php echo $pageDescription; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
