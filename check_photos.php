<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\App\Models\User::all() as $user) {
    if ($user->photo) {
        $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo);
        echo "User {$user->id}: {$user->photo} - Exists on disk? " . ($exists ? 'Yes' : 'No') . PHP_EOL;
    }
}
