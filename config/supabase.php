<?php

return [
    'url' => env('SUPABASE_URL'),
    'key' => env('SUPABASE_KEY'),
    'database_url' => env('SUPABASE_DB_URL'),
    'default' => env('DB_CONNECTION') === 'supabase',
];
