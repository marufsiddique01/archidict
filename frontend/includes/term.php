<?php
/**
 * Term Management Class for Frontend
 */
class Term {
    private $db;
    
    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Get all terms
     * 
     * @return array Array of terms
     */
    public function getAll() {
        $this->db->query("SELECT * FROM terms ORDER BY name ASC");
        return $this->db->resultSet();
    }
    
    /**
     * Get term by ID
     * 
     * @param int $id The term ID
     * @return array|bool Term details or false if not found
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM terms WHERE id = :id");
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    /**
     * Get term by slug
     * 
     * @param string $slug The term slug
     * @return array|bool Term details or false if not found
     */
    public function getBySlug($slug) {
        $this->db->query("SELECT * FROM terms WHERE slug = :slug");
        $this->db->bind(':slug', $slug);
        
        return $this->db->single();
    }
    
    /**
     * Get related terms for a term
     * 
     * @param int $termId The term ID
     * @return array Array of related terms with complete details
     */
    public function getRelatedTermsWithDetails($termId) {
        $this->db->query("
            SELECT t.* 
            FROM terms t
            INNER JOIN term_relationships tr ON t.id = tr.related_term_id
            WHERE tr.term_id = :term_id
            ORDER BY t.name ASC
        ");
        $this->db->bind(':term_id', $termId);
        
        return $this->db->resultSet();
    }
    
    /**
     * Search for terms
     * 
     * @param string $keyword The search keyword
     * @return array Array of matching terms
     */
    public function search($keyword) {
        $this->db->query("SELECT * FROM terms WHERE name LIKE :keyword OR definition LIKE :keyword ORDER BY name ASC");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        
        return $this->db->resultSet();
    }
    
    /**
     * Get terms grouped by first letter
     * 
     * @return array Terms organized by first letter
     */
    public function getTermsByAlphabet() {
        // Get all terms
        $this->db->query("SELECT * FROM terms ORDER BY name ASC");
        $terms = $this->db->resultSet();
        
        // Group terms by first letter
        $termsByLetter = [];
        foreach ($terms as $term) {
            // Get first letter and convert to uppercase
            $firstLetter = mb_strtoupper(mb_substr($term['name'], 0, 1, 'UTF-8'), 'UTF-8');
            
            // If the first letter is not alphabetic, group under '#'
            if (!preg_match('/[A-Za-z]/', $firstLetter)) {
                $firstLetter = '#';
            }
            
            // Add term to appropriate group
            if (!isset($termsByLetter[$firstLetter])) {
                $termsByLetter[$firstLetter] = [];
            }
            
            $termsByLetter[$firstLetter][] = $term;
        }
        
        // Sort letters alphabetically
        ksort($termsByLetter);
        
        return $termsByLetter;
    }
    
    /**
     * Get terms by specific letter
     * 
     * @param string $letter The letter to filter by
     * @return array Terms starting with the given letter
     */
    public function getTermsByLetter($letter) {
        // If $letter is '#', get all terms starting with non-alphabetic character
        if ($letter == '#') {
            $this->db->query("
                SELECT * 
                FROM terms
                WHERE name REGEXP '^[^a-zA-Z]'
                ORDER BY name ASC
            ");
        } else {
            $this->db->query("
                SELECT * 
                FROM terms
                WHERE name LIKE :letter
                ORDER BY name ASC
            ");
            $this->db->bind(':letter', $letter . '%');
        }
        
        return $this->db->resultSet();
    }
    
    /**
     * Get all available letters that have terms
     * 
     * @return array Array of letters
     */
    public function getAvailableLetters() {
        $termsByLetter = $this->getTermsByAlphabet();
        return array_keys($termsByLetter);
    }
    
    /**
     * Get random terms
     * 
     * @param int $limit Number of terms to get
     * @return array Random terms
     */
    public function getRandomTerms($limit = 6) {
        $this->db->query("SELECT * FROM terms ORDER BY RAND() LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }
    
    /**
     * Get total count of terms
     * 
     * @return int Total number of terms
     */
    public function getTotalCount() {
        $this->db->query("SELECT COUNT(*) as count FROM terms");
        $result = $this->db->single();
        
        return $result['count'];
    }
}
?>
