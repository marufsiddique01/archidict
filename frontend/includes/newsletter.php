<?php
/**
 * Newsletter Management Class for Frontend
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
     * Get latest newsletters
     * 
     * @param int $limit Number of newsletters to return
     * @return array Latest newsletters
     */
    public function getLatest($limit = 5) {
        $this->db->query("SELECT * FROM newsletters ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }
    
    /**
     * Get total count of newsletters
     * 
     * @return int Total number of newsletters
     */
    public function getTotalCount() {
        $this->db->query("SELECT COUNT(*) as count FROM newsletters");
        $result = $this->db->single();
        
        return $result['count'];
    }
}
?>
