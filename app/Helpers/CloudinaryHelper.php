<?php

use Cloudinary\Api\Upload\UploadApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        Log::warning("CloudinaryHelper: Failed to get secure_url. Type: " . gettype($uploadedFile) . ", Class: " . (is_object($uploadedFile) ? get_class($uploadedFile) : 'N/A'));
        
        return null;
    }
}

if (!function_exists('getCloudinaryCredentials')) {
    function getCloudinaryCredentials(): ?array {
        $cloudUrl = env('CLOUDINARY_URL') ?: config('cloudinary.cloud_url');
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_KEY') ?: env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_SECRET') ?: env('CLOUDINARY_API_SECRET');

        if ((!$cloudName || !$apiKey || !$apiSecret) && $cloudUrl) {
            $pattern = '#cloudinary://(?P<api_key>[^:]+):(?P<api_secret>[^@]+)@(?P<cloud_name>[^/]+)#';
            if (preg_match($pattern, $cloudUrl, $matches)) {
                $cloudName = $cloudName ?: ($matches['cloud_name'] ?? null);
                $apiKey = $apiKey ?: ($matches['api_key'] ?? null);
                $apiSecret = $apiSecret ?: ($matches['api_secret'] ?? null);
            }
        }

        if ($cloudName && $apiKey && $apiSecret) {
            return [
                'cloud_name' => $cloudName,
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
                'cloud_url' => $cloudUrl,
            ];
        }

        return null;
    }
}

if (!function_exists('isCloudinaryUrl')) {
    function isCloudinaryUrl(?string $path): bool {
        if (!$path) {
            return false;
        }

        return str_contains($path, 'cloudinary.com') || str_contains($path, 'res.cloudinary.com');
    }
}

if (!function_exists('shouldUseCloudinaryUploads')) {
    function shouldUseCloudinaryUploads(): bool {
        if (env('FORCE_LOCAL_UPLOADS')) {
            return false;
        }

        return (bool) getCloudinaryCredentials();
    }
}

if (!function_exists('format_local_storage_path')) {
    function format_local_storage_path(string $relativePath): string {
        $relativePath = ltrim($relativePath, '/');
        $relativePath = ltrim(str_replace('storage/', '', $relativePath), '/');

        return 'storage/' . $relativePath;
    }
}

if (!function_exists('uploadImageWithCloudinaryFallback')) {
    /**
     * Upload file ke Cloudinary jika tersedia, fallback ke local storage (public disk)
     */
    function uploadImageWithCloudinaryFallback(UploadedFile $file, string $cloudFolder, string $localFolder = 'uploads'): string {
        $cloudFolder = trim($cloudFolder, '/');
        $cloudErrors = [];
        $credentials = getCloudinaryCredentials();
        $shouldUseCloudinary = shouldUseCloudinaryUploads() && (bool) $credentials;

        if ($shouldUseCloudinary && $credentials) {
            // Prefer direct UploadApi instantiation to bypass facade config issues
            try {
                $uploadApi = new UploadApi([
                    'cloud_name' => $credentials['cloud_name'],
                    'api_key' => $credentials['api_key'],
                    'api_secret' => $credentials['api_secret'],
                ]);

                $result = $uploadApi->upload($file->getRealPath(), [
                    'folder' => $cloudFolder,
                    'resource_type' => 'image',
                ]);

                $url = $result['secure_url'] ?? $result['url'] ?? null;
                if ($url) {
                    Log::info("Cloudinary upload success (UploadApi): {$url}");
                    return $url;
                }

                $cloudErrors[] = 'Cloudinary UploadApi tidak mengembalikan URL.';
            } catch (\Throwable $e) {
                $cloudErrors[] = $e->getMessage();
                Log::error('Cloudinary UploadApi error: ' . $e->getMessage());
            }

            // Fallback to facade as secondary attempt
            try {
                $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                    'folder' => $cloudFolder,
                    'resource_type' => 'image',
                ]);

                $url = getCloudinarySecureUrl($uploadedFile);
                if ($url) {
                    Log::info("Cloudinary upload success (Facade fallback): {$url}");
                    return $url;
                }

                $cloudErrors[] = 'Cloudinary facade tidak mengembalikan URL.';
            } catch (\Throwable $e) {
                $cloudErrors[] = $e->getMessage();
                Log::error('Cloudinary facade error: ' . $e->getMessage());
            }
        } elseif (!$credentials && shouldUseCloudinaryUploads()) {
            $cloudErrors[] = 'Kredensial Cloudinary belum dikonfigurasi.';
        }

        try {
            $storedRelativePath = $file->store($localFolder, 'public');
            $formattedPath = format_local_storage_path($storedRelativePath);
            Log::info("Local upload success: {$formattedPath}");
            return $formattedPath;
        } catch (\Throwable $e) {
            $message = 'Gagal menyimpan file lokal: ' . $e->getMessage();
            if ($cloudErrors) {
                $message .= ' | Cloudinary: ' . implode(' | ', array_unique($cloudErrors));
            }
            Log::error($message);
            throw new \RuntimeException($message, 0, $e);
        }
    }
}

if (!function_exists('deleteUploadedAsset')) {
    function deleteUploadedAsset(?string $path): void {
        if (!$path) {
            return;
        }

        if (isCloudinaryUrl($path)) {
            try {
                $parsedPath = parse_url($path, PHP_URL_PATH);
                $publicId = null;

                if ($parsedPath) {
                    $segments = explode('/upload/', $parsedPath);
                    $afterUpload = $segments[1] ?? ltrim($parsedPath, '/');
                    $afterUpload = ltrim($afterUpload, '/');
                    $publicId = preg_replace('/\.[^.]+$/', '', $afterUpload);
                }

                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to delete Cloudinary asset: ' . $e->getMessage());
            }

            return;
        }

        $relativePath = ltrim(str_replace('storage/', '', $path), '/');
        if (!$relativePath) {
            return;
        }

        try {
            Storage::disk('public')->delete($relativePath);
        } catch (\Throwable $e) {
            Log::warning('Failed to delete local asset: ' . $e->getMessage());
        }
    }
}

