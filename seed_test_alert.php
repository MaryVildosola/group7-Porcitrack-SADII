<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pig;
use App\Models\PigActivity;

$pig = Pig::first();
$user = \App\Models\User::first();
if ($pig && $user) {
    PigActivity::create([
        'pig_id' => $pig->id,
        'user_id' => $user->id,
        'type' => 'Medical',
        'action' => '🚨 CRITICAL ALERT — Health In Danger',
        'details' => 'I need immediate medical attention! (System Test)',
        'is_critical_alert' => true,
        'created_at' => now(),
    ]);
    echo "SUCCESS: Created test alert for Pig #" . $pig->tag . "\n";
} else {
    echo "ERROR: No pigs found in database.\n";
}
