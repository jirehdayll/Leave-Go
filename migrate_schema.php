<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Starting migrations...\n";

    // 1. Fix leave_requests table
    echo "Adding columns to leave_requests...\n";
    DB::statement("ALTER TABLE leave_requests ADD COLUMN IF NOT EXISTS is_starred BOOLEAN DEFAULT FALSE");
    DB::statement("ALTER TABLE leave_requests ADD COLUMN IF NOT EXISTS details JSONB DEFAULT '{}'");

    // 2. Prepare users table for UUID (Sync with Supabase Auth)
    echo "Migrating users table to UUID...\n";
    
    // Check if ID is already UUID
    $idType = DB::selectOne("
        SELECT data_type 
        FROM information_schema.columns 
        WHERE table_schema = 'public' 
          AND table_name = 'users' 
          AND column_name = 'id'
    ")->data_type;

    if ($idType !== 'uuid') {
        // We need to change the ID type. Since there might be foreign keys, we handle it carefully.
        // For this project, we'll assume it's safe to drop/recreate or cast if no FKs exist.
        DB::statement("ALTER TABLE users ALTER COLUMN id DROP DEFAULT");
        DB::statement("ALTER TABLE users ALTER COLUMN id TYPE UUID USING (gen_random_uuid())");
        DB::statement("ALTER TABLE users ALTER COLUMN id SET DEFAULT gen_random_uuid()");
    }

    // 3. Create Sync Function and Trigger
    echo "Creating Supabase Auth sync function and trigger...\n";
    
    DB::unprepared("
        -- Function to sync users
        CREATE OR REPLACE FUNCTION public.handle_new_user()
        RETURNS trigger AS $$
        BEGIN
          INSERT INTO public.users (id, name, email, created_at, updated_at)
          VALUES (new.id, new.raw_user_meta_data->>'name', new.email, now(), now())
          ON CONFLICT (id) DO UPDATE SET
            name = EXCLUDED.name,
            email = EXCLUDED.email,
            updated_at = now();
          RETURN new;
        END;
        $$ LANGUAGE plpgsql SECURITY DEFINER;

        -- Trigger to call function on signup
        DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;
        CREATE TRIGGER on_auth_user_created
          AFTER INSERT ON auth.users
          FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();
    ");

    echo "Migrations completed successfully!\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
