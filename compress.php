<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$directory = storage_path('app/public/users');
$files = glob($directory . '/*');

$manager = new ImageManager(new Driver());

$count = 0;
foreach ($files as $file) {
    if (is_file($file)) {
        echo "Processing " . basename($file) . "\n";
        try {
            $image = $manager->read($file);
            $image->scaleDown(width: 300);
            $image->toJpeg(80)->save($file);
            $count++;
        } catch (\Exception $e) {
            echo "Failed to process " . basename($file) . ": " . $e->getMessage() . "\n";
        }
    }
}

echo "Successfully compressed $count images.\n";
