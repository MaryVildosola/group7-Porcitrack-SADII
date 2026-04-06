<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$testFile = 'users/test_delete_123.jpg';

// create file
file_put_contents(storage_path('app/public/' . $testFile), 'test file contents');

if (file_exists(storage_path('app/public/' . $testFile))) {
    echo "File created successfully.\n";
} else {
    echo "File creation failed.\n";
    exit;
}

// try delete using Storage facade
\Illuminate\Support\Facades\Storage::disk('public')->delete($testFile);

if (file_exists(storage_path('app/public/' . $testFile))) {
    echo "Storage::delete SILENTLY FAILED!\n";
} else {
    echo "Storage::delete SUCCEEDED!\n";
}
