<?php

require __DIR__ . '/vendor/autoload.php';

// Enhanced Bootstrapping
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap(); // Basic bootstrapping

// Force loading of environment variables from .env
if (!function_exists('env')) {
    Dotenv\Dotenv::createImmutable(__DIR__)->load();
}

use Illuminate\Database\Capsule\Manager as DB;

$count = DB::table('lms_g41_departments')->count();
echo "Department Count: " . $count;
