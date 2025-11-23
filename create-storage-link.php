<?php
/**
 * Manual Storage Link Creator
 * 
 * This script creates the storage symlink without using exec()
 * Run this file once via browser or CLI: php create-storage-link.php
 * 
 * IMPORTANT: Delete this file after use for security!
 */

$publicPath = __DIR__ . '/public';
$storagePath = __DIR__ . '/storage/app/public';
$linkPath = $publicPath . '/storage';

// Check if storage directory exists
if (!is_dir($storagePath)) {
    echo "Error: Storage directory not found at: $storagePath\n";
    echo "Please ensure the storage/app/public directory exists.\n";
    exit(1);
}

// Check if link already exists
if (file_exists($linkPath) || is_link($linkPath)) {
    if (is_link($linkPath)) {
        $target = readlink($linkPath);
        if ($target === '../storage/app/public' || $target === $storagePath) {
            echo "✓ Storage link already exists and points to the correct location.\n";
            exit(0);
        } else {
            echo "Warning: A link exists but points to: $target\n";
            echo "Removing old link...\n";
            unlink($linkPath);
        }
    } else {
        echo "Warning: A file or directory named 'storage' already exists in public folder.\n";
        echo "Please remove it manually before creating the symlink.\n";
        exit(1);
    }
}

// Try to create symlink using PHP's symlink() function
if (function_exists('symlink')) {
    // Use relative path for better portability
    $relativeTarget = '../storage/app/public';
    
    if (@symlink($relativeTarget, $linkPath)) {
        echo "✓ Storage link created successfully!\n";
        echo "Link: $linkPath -> $relativeTarget\n";
        exit(0);
    } else {
        $error = error_get_last();
        echo "Error creating symlink: " . ($error['message'] ?? 'Unknown error') . "\n";
        echo "\n";
        echo "Alternative: Create the symlink manually via:\n";
        echo "1. FTP/cPanel File Manager\n";
        echo "2. SSH: cd public && ln -s ../storage/app/public storage\n";
        exit(1);
    }
} else {
    echo "Error: symlink() function is not available on this server.\n";
    echo "\n";
    echo "Please create the symlink manually:\n";
    echo "1. Via FTP/cPanel File Manager:\n";
    echo "   - Go to 'public' folder\n";
    echo "   - Create symbolic link named 'storage' pointing to '../storage/app/public'\n";
    echo "\n";
    echo "2. Via SSH (if available):\n";
    echo "   cd public\n";
    echo "   ln -s ../storage/app/public storage\n";
    exit(1);
}

