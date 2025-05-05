<?php
/**
 * Newsletter Management Class
 */
class Newsletter {
    private $db;
    
    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Get all newsletters
     * 
     * @return array Array of newsletters
     */
    public function getAll() {
        $this->db->query("SELECT * FROM newsletters ORDER BY created_at DESC");
        return $this->db->resultSet();
    }
    
    /**
     * Get newsletter by ID
     * 
     * @param int $id The newsletter ID
     * @return array|bool Newsletter details or false if not found
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM newsletters WHERE id = :id");
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    /**
     * Create a new newsletter
     * 
     * @param array $data Newsletter data
     * @return bool|string True if successful, error message otherwise
     */
    public function create($data) {
        // Insert newsletter
        $this->db->query("INSERT INTO newsletters (title, description, file_path) VALUES (:title, :description, :file_path)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':file_path', $data['file_path']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return "Failed to create newsletter. Please try again.";
        }
    }
    
    /**
     * Update an existing newsletter
     * 
     * @param int $id The newsletter ID
     * @param array $data Newsletter data
     * @return bool|string True if successful, error message otherwise
     */
    public function update($id, $data) {
        // Get existing newsletter
        $existingNewsletter = $this->getById($id);
        if (!$existingNewsletter) {
            return "Newsletter not found.";
        }
        
        // Build query based on provided data
        $query = "UPDATE newsletters SET title = :title, description = :description";
        
        // Add file path to query if provided
        if (isset($data['file_path'])) {
            $query .= ", file_path = :file_path";
        }
        
        $query .= " WHERE id = :id";
        
        // Execute query
        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':id', $id);
        
        if (isset($data['file_path'])) {
            $this->db->bind(':file_path', $data['file_path']);
        }
        
        if ($this->db->execute()) {
            return true;
        } else {
            return "Failed to update newsletter. Please try again.";
        }
    }
    
    /**
     * Delete a newsletter
     * 
     * @param int $id The newsletter ID
     * @return bool|string True if successful, error message otherwise
     */
    public function delete($id) {
        // Get newsletter to check if it exists
        $newsletter = $this->getById($id);
        if (!$newsletter) {
            return "Newsletter not found.";
        }
        
        // Delete the newsletter
        $this->db->query("DELETE FROM newsletters WHERE id = :id");
        $this->db->bind(':id', $id);
        
        if ($this->db->execute()) {
            // Delete file if exists
            if (!empty($newsletter['file_path'])) {
                $filePath = NEWSLETTER_UPLOADS . $newsletter['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            return true;
        } else {
            return "Failed to delete newsletter. Please try again.";
        }
    }
    
    /**
     * Search for newsletters
     * 
     * @param string $keyword The search keyword
     * @return array Array of matching newsletters
     */
    public function search($keyword) {
        $this->db->query("SELECT * FROM newsletters WHERE title LIKE :keyword OR description LIKE :keyword ORDER BY created_at DESC");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        
        return $this->db->resultSet();
    }
}
