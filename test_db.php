<?php
try {
    $pdo = new PDO('pgsql:host=db.tfawifybdvmuclwusdhk.supabase.co;port=5432;dbname=postgres', 'postgres.tfawifybdvmuclwusdhk', 'LeaveGoDB2026!');
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema='public'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in public schema:\n";
    print_r($tables);
    
    // Add user count
    $stmt2 = $pdo->query("SELECT COUNT(*) FROM users");
    $count = $stmt2->fetchColumn();
    echo "Total users in users table: $count\n";

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
