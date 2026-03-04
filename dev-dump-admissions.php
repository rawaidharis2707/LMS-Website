<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AdmissionRequest;

$count = AdmissionRequest::count();
echo "Admissions count: " . $count . PHP_EOL;

$latest = AdmissionRequest::orderByDesc('created_at')->limit(3)->get();
foreach ($latest as $a) {
    echo "{$a->application_id} | {$a->full_name} | {$a->class_applying} | {$a->created_at}\n";
}

