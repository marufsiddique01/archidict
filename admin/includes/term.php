<?php
/**
 * Term Management Class
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
     * Create a new term
     * 
     * @param array $data Term data
     * @return bool|string True if successful, error message otherwise
     */
    public function create($data) {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Utils::slugify($data['name']);
        } else {
            $data['slug'] = Utils::slugify($data['slug']);
        }
        
        // Check if slug already exists
        $existingTerm = $this->getBySlug($data['slug']);
        if ($existingTerm) {
            return "A term with this slug already exists.";
        }
        
        // Insert term
        $this->db->query("INSERT INTO terms (name, slug, definition, image) VALUES (:name, :slug, :definition, :image)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':definition', $data['definition']);
        $this->db->bind(':image', $data['image'] ?? null);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return "Failed to create term. Please try again.";
        }
    }
    
    /**
     * Update an existing term
     * 
     * @param int $id The term ID
     * @param array $data Term data
     * @return bool|string True if successful, error message otherwise
     */
    public function update($id, $data) {
        // Get existing term
        $existingTerm = $this->getById($id);
        if (!$existingTerm) {
            return "Term not found.";
        }
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Utils::slugify($data['name']);
        } else {
            $data['slug'] = Utils::slugify($data['slug']);
        }
        
        // Check if slug already exists and belongs to another term
        if ($data['slug'] !== $existingTerm['slug']) {
            $termWithSlug = $this->getBySlug($data['slug']);
            if ($termWithSlug) {
                return "A term with this slug already exists.";
            }
        }
        
        // Update term
        $this->db->query("UPDATE terms SET name = :name, slug = :slug, definition = :definition" . 
                        (isset($data['image']) ? ", image = :image" : "") . 
                        " WHERE id = :id");
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':definition', $data['definition']);
        $this->db->bind(':id', $id);
        
        if (isset($data['image'])) {
            $this->db->bind(':image', $data['image']);
        }
        
        if ($this->db->execute()) {
            return true;
        } else {
            return "Failed to update term. Please try again.";
        }
    }
    
    /**
     * Delete a term
     * 
     * @param int $id The term ID
     * @return bool|string True if successful, error message otherwise
     */
    public function delete($id) {
        // Get term to check if it exists
        $term = $this->getById($id);
        if (!$term) {
            return "Term not found.";
        }
        
        // Begin transaction
        $this->db->beginTransaction();
        
        // Delete related terms first
        $this->db->query("DELETE FROM term_relationships WHERE term_id = :id OR related_term_id = :id");
        $this->db->bind(':id', $id);
        
        if (!$this->db->execute()) {
            $this->db->rollBack();
            return "Failed to delete term relationships.";
        }
        
        // Delete the term
        $this->db->query("DELETE FROM terms WHERE id = :id");
        $this->db->bind(':id', $id);
        
        if ($this->db->execute()) {
            $this->db->commit();
            
            // Delete image file if exists
            if (!empty($term['image'])) {
                $imagePath = TERMS_UPLOADS . $term['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            return true;
        } else {
            $this->db->rollBack();
            return "Failed to delete term. Please try again.";
        }
    }
    
    /**
     * Get related terms for a term
     * 
     * @param int $termId The term ID
     * @return array Array of related term IDs
     */
    public function getRelatedTerms($termId) {
        $this->db->query("SELECT related_term_id FROM term_relationships WHERE term_id = :term_id");
        $this->db->bind(':term_id', $termId);
        
        $results = $this->db->resultSet();
        $relatedTerms = [];
        
        foreach ($results as $row) {
            $relatedTerms[] = $row['related_term_id'];
        }
        
        return $relatedTerms;
    }
    
    /**
     * Set related terms for a term
     * 
     * @param int $termId The term ID
     * @param array $relatedTermIds Array of related term IDs
     * @return bool|string True if successful, error message otherwise
     */
    public function setRelatedTerms($termId, $relatedTermIds) {
        // Begin transaction
        $this->db->beginTransaction();
        
        // Delete existing relationships
        $this->db->query("DELETE FROM term_relationships WHERE term_id = :term_id");
        $this->db->bind(':term_id', $termId);
        
        if (!$this->db->execute()) {
            $this->db->rollBack();
            return "Failed to update term relationships.";
        }
        
        // Add new relationships
        if (!empty($relatedTermIds)) {
            foreach ($relatedTermIds as $relatedTermId) {
                // Skip if trying to relate to itself
                if ($termId == $relatedTermId) {
                    continue;
                }
                
                $this->db->query("INSERT INTO term_relationships (term_id, related_term_id) VALUES (:term_id, :related_term_id)");
                $this->db->bind(':term_id', $termId);
                $this->db->bind(':related_term_id', $relatedTermId);
                
                if (!$this->db->execute()) {
                    $this->db->rollBack();
                    return "Failed to add term relationship.";
                }
            }
        }
        
        $this->db->commit();
        return true;
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
}
