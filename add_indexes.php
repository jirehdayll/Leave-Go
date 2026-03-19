<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Adding indexes for performance...\n";
    DB::statement("CREATE INDEX IF NOT EXISTS idx_leave_requests_status ON leave_requests(status)");
    DB::statement("CREATE INDEX IF NOT EXISTS idx_leave_requests_type ON leave_requests(type)");
    DB::statement("CREATE INDEX IF NOT EXISTS idx_leave_requests_is_starred ON leave_requests(is_starred)");
    echo "Indexes added successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
