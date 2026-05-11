<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Data;

Data::whereNull('uid')->get()->each(function($data) {
    $data->update(['uid' => Data::generateUniqueUid()]);
});
echo "Done filling UIDs\n";
