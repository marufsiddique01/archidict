<?php
/**
 * Utilities Class for common functions
 */
class Utils {
    /**
     * Sanitize input data
     * 
     * @param mixed $data The input data to sanitize
     * @return mixed Sanitized data
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }
        
        // Remove whitespace from beginning and end
        $data = trim($data);
        // Convert special characters to HTML entities
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
    
    /**
     * Generate a URL slug from a string
     * 
     * @param string $string The string to convert to a slug
     * @return string The URL slug
     */
    public static function slugify($string) {
        // Convert to lowercase
        $string = mb_strtolower($string, 'UTF-8');
        
        // Replace non-alphanumeric characters with hyphens
        $string = preg_replace('/[^a-z0-9]+/i', '-', $string);
        
        // Remove duplicate hyphens
        $string = preg_replace('/-+/', '-', $string);
        
        // Remove leading and trailing hyphens
        $string = trim($string, '-');
        
        return $string;
    }
    
    /**
     * Format a date
     * 
     * @param string $date The date to format
     * @param string $format The format to use
     * @return string The formatted date
     */
    public static function formatDate($date, $format = 'Y-m-d H:i:s') {
        return date($format, strtotime($date));
    }
}
