<?php

if (!function_exists('getCloudinarySecureUrl')) {
    /**
     * Helper function untuk mendapatkan secure URL dari Cloudinary response
     * 
     * @param mixed $uploadedFile
     * @return string|null
     */
    function getCloudinarySecureUrl($uploadedFile) {
        if (!$uploadedFile) {
            return null;
        }
        
        // Jika sudah string/URL, return langsung
        if (is_string($uploadedFile) && filter_var($uploadedFile, FILTER_VALIDATE_URL)) {
            return $uploadedFile;
        }
        
        // Coba convert ke array
        $array = null;
        if (is_object($uploadedFile)) {
            // Coba berbagai method untuk convert ke array
            if (method_exists($uploadedFile, 'getArrayCopy')) {
                try {
                    $array = $uploadedFile->getArrayCopy();
                } catch (\Exception $e) {
                    // Ignore
                }
            }
            
            if (!$array && method_exists($uploadedFile, 'toArray')) {
                try {
                    $array = $uploadedFile->toArray();
                } catch (\Exception $e) {
                    // Ignore
                }
            }
            
            if (!$array) {
                try {
                    $json = json_encode($uploadedFile);
                    $array = json_decode($json, true);
                } catch (\Exception $e) {
                    // Ignore
                }
            }
            
            // Coba method getSecurePath()
            if (method_exists($uploadedFile, 'getSecurePath')) {
                try {
                    $url = $uploadedFile->getSecurePath();
                    if ($url) return $url;
                } catch (\Exception $e) {
                    // Ignore
                }
            }
            
            // Coba property
            if (property_exists($uploadedFile, 'secure_url')) {
                try {
                    $reflection = new \ReflectionClass($uploadedFile);
                    $property = $reflection->getProperty('secure_url');
                    $property->setAccessible(true);
                    $url = $property->getValue($uploadedFile);
                    if ($url) return $url;
                } catch (\Exception $e) {
                    // Try direct access
                    try {
                        $url = $uploadedFile->secure_url;
                        if ($url) return $url;
                    } catch (\Exception $e2) {
                        // Ignore
                    }
                }
            }
            
            // Coba array access
            if (isset($uploadedFile['secure_url'])) {
                return $uploadedFile['secure_url'];
            }
        } elseif (is_array($uploadedFile)) {
            $array = $uploadedFile;
        }
        
        // Ambil dari array
        if ($array && isset($array['secure_url'])) {
            return $array['secure_url'];
        }
        
        // Log untuk debug jika tidak berhasil
        \Illuminate\Support\Facades\Log::warning("CloudinaryHelper: Failed to get secure_url. Type: " . gettype($uploadedFile) . ", Class: " . (is_object($uploadedFile) ? get_class($uploadedFile) : 'N/A'));
        
        return null;
    }
}

