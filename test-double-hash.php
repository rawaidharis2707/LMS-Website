<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = new User();
$user->password = 'password';

echo "Original password: password\n";
echo "Stored password: " . $user->password . "\n";

if (Hash::check('password', $user->password)) {
    echo "Correctly hashed! (Single hashing detected)\n";
} else {
    echo "Double hashed! (Hash::make was likely applied twice)\n";
}
