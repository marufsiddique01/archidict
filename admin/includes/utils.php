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
        // Replace spaces with hyphens
        $string = str_replace(' ', '-', $string);
        // Remove special characters
        $string = preg_replace('/[^a-z0-9\-]/', '', $string);
        // Replace multiple hyphens with a single hyphen
        $string = preg_replace('/-+/', '-', $string);
        // Trim hyphens from beginning and end
        return trim($string, '-');
    }
    
    /**
     * Format date for display
     * 
     * @param string $date The date string to format
     * @param string $format The date format (default: Y-m-d H:i:s)
     * @return string Formatted date
     */
    public static function formatDate($date, $format = 'Y-m-d H:i:s') {
        $dateObj = new DateTime($date);
        return $dateObj->format($format);
    }
    
    /**
     * Display success message
     * 
     * @param string $message The success message
     * @return string HTML for success message
     */
    public static function displaySuccess($message) {
        return '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $message . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
    
    /**
     * Display error message
     * 
     * @param string $message The error message
     * @return string HTML for error message
     */
    public static function displayError($message) {
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $message . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
    
    /**
     * Validate image file upload
     * 
     * @param array $file The uploaded file array
     * @param int $maxSize Maximum file size in bytes (default: 2MB)
     * @param array $allowedTypes Allowed MIME types (default: common image types)
     * @return array|bool Result array or false on failure
     */
    public static function validateImageUpload($file, $maxSize = 2097152, $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No file uploaded'];
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
            ];
            
            $errorMessage = isset($errors[$file['error']]) ? $errors[$file['error']] : 'Unknown upload error.';
            return ['success' => false, 'message' => $errorMessage];
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'File size exceeds the maximum allowed size (' . self::formatSizeUnits($maxSize) . ').'];
        }
        
        // Check file type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Allowed types: ' . implode(', ', array_map(function($type) {
                return str_replace('image/', '', $type);
            }, $allowedTypes)) . '.'];
        }
        
        return ['success' => true, 'message' => 'File is valid.'];
    }
    
    /**
     * Validate PDF file upload
     * 
     * @param array $file The uploaded file array
     * @param int $maxSize Maximum file size in bytes (default: 5MB)
     * @return array|bool Result array or false on failure
     */
    public static function validatePdfUpload($file, $maxSize = 5242880) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No file uploaded'];
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
            ];
            
            $errorMessage = isset($errors[$file['error']]) ? $errors[$file['error']] : 'Unknown upload error.';
            return ['success' => false, 'message' => $errorMessage];
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'File size exceeds the maximum allowed size (' . self::formatSizeUnits($maxSize) . ').'];
        }
        
        // Check file type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if ($mime !== 'application/pdf') {
            return ['success' => false, 'message' => 'Invalid file type. Only PDF files are allowed.'];
        }
        
        return ['success' => true, 'message' => 'File is valid.'];
    }
    
    /**
     * Format file size in human-readable units
     * 
     * @param int $bytes The file size in bytes
     * @return string Formatted file size
     */
    public static function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }
    
    /**
     * Generate a unique filename
     * 
     * @param string $originalName The original filename
     * @return string A unique filename
     */
    public static function generateUniqueFilename($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $basename = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Sanitize basename
        $basename = self::slugify($basename);
        
        // Add timestamp and random string to ensure uniqueness
        $unique = sprintf('%s-%s-%s', $basename, time(), substr(md5(mt_rand()), 0, 6));
        
        return $unique . '.' . $extension;
    }
}
