<?php
/**
 * Admin Profile Page
 */
// Page title
$pageTitle = 'My Profile';

// Include initialization file
require_once 'includes/config.php';
require_once 'includes/init.php';

// Require user to be logged in
requireLogin();

// Get current user
$user = $auth->getUserById($_SESSION['user_id']);

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which form was submitted
    if (isset($_POST['update_profile'])) {
        // Profile update form
        $email = Utils::sanitize($_POST['email'] ?? '');
        
        // Validate input
        if (empty($email)) {
            $message = 'Email is required.';
            $messageType = 'danger';
        } else {
            // Update profile
            $result = $auth->updateProfile($_SESSION['user_id'], $email);
            
            if ($result === true) {
                $message = 'Profile updated successfully.';
                $messageType = 'success';
                
                // Refresh user data
                $user = $auth->getUserById($_SESSION['user_id']);
            } else {
                $message = $result;
                $messageType = 'danger';
            }
        }
    } elseif (isset($_POST['change_password'])) {
        // Password change form
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate inputs
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $message = 'All password fields are required.';
            $messageType = 'danger';
        } elseif ($newPassword !== $confirmPassword) {
            $message = 'New passwords do not match.';
            $messageType = 'danger';
        } elseif (strlen($newPassword) < 8) {
            $message = 'New password must be at least 8 characters long.';
            $messageType = 'danger';
        } else {
            // Change password
            $result = $auth->changePassword($_SESSION['user_id'], $currentPassword, $newPassword);
            
            if ($result === true) {
                $message = 'Password changed successfully.';
                $messageType = 'success';
            } else {
                $message = $result;
                $messageType = 'danger';
            }
        }
    }
}

// Include header template
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">My Profile</h1>
    </div>
</div>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                        <div class="form-text">Username cannot be changed.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Change Password</h5>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer template
include 'includes/footer.php';
?>
