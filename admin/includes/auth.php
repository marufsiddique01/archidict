<?php
/**
 * Authentication and User Management Class
 */
class Auth {
    private $db;
    
    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Check if user is logged in
     * 
     * @return bool True if user is logged in, false otherwise
     */
    public function isLoggedIn() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }
    
    /**
     * Authenticate a user
     * 
     * @param string $username The username
     * @param string $password The password (plaintext)
     * @return bool True if authentication successful, false otherwise
     */
    public function login($username, $password) {
        // Sanitize inputs
        $username = Utils::sanitize($username);
        
        // Check if username exists
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        
        $user = $this->db->single();
        
        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                // Update last login time
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Log out the current user
     * 
     * @return void
     */
    public function logout() {
        // Unset all session variables
        $_SESSION = [];
        
        // If a session cookie is used, invalidate the cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
    }
    
    /**
     * Change a user's password
     * 
     * @param int $userId The user ID
     * @param string $currentPassword The current password
     * @param string $newPassword The new password
     * @return bool|string True if successful, error message otherwise
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        // Get user details
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $userId);
        
        $user = $this->db->single();
        
        if (!$user) {
            return "User not found.";
        }
        
        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            return "Current password is incorrect.";
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);
        
        // Update password
        $this->db->query("UPDATE users SET password = :password, updated_at = NOW() WHERE id = :id");
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':id', $userId);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return "Failed to update password. Please try again.";
        }
    }
    
    /**
     * Update user profile information
     * 
     * @param int $userId The user ID
     * @param string $email The email address
     * @return bool|string True if successful, error message otherwise
     */
    public function updateProfile($userId, $email) {
        // Sanitize inputs
        $email = Utils::sanitize($email);
        
        // Check if email already exists
        $this->db->query("SELECT * FROM users WHERE email = :email AND id != :id");
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $userId);
        
        if ($this->db->single()) {
            return "Email address already in use.";
        }
        
        // Update profile
        $this->db->query("UPDATE users SET email = :email, updated_at = NOW() WHERE id = :id");
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $userId);
        
        if ($this->db->execute()) {
            // Update session
            $_SESSION['email'] = $email;
            return true;
        } else {
            return "Failed to update profile. Please try again.";
        }
    }
    
    /**
     * Get user details by ID
     * 
     * @param int $userId The user ID
     * @return array|bool User details or false if not found
     */
    public function getUserById($userId) {
        $this->db->query("SELECT id, username, email, created_at, updated_at FROM users WHERE id = :id");
        $this->db->bind(':id', $userId);
        
        return $this->db->single();
    }
}
