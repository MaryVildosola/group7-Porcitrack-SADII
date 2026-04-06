<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbPhotos = \App\Models\User::whereNotNull('photo')->pluck('photo')->toArray();
$directory = storage_path('app/public/users');
$files = glob($directory . '/*');

$deletedCount = 0;
foreach ($files as $file) {
    if (is_file($file)) {
        $basename = basename($file);
        $relativePath = 'users/' . $basename;
        
        if (!in_array($relativePath, $dbPhotos)) {
            echo "Deleting orphaned file: $relativePath\n";
            unlink($file);
            $deletedCount++;
        }
    }
}

echo "Cleaned up $deletedCount orphaned photos.\n";
