<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'student@demo.com';
$password = 'password';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "User not found!\n";
} else {
    echo "User found: " . $user->name . "\n";
    if (Hash::check($password, $user->password)) {
        echo "Password matches!\n";
    } else {
        echo "Password does NOT match!\n";
    }
}
