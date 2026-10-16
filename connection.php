<?php
// ------------------------------------------------------------
// Database connection (InfinityFree)
// Every page includes this file with: require_once 'connection.php';
// ------------------------------------------------------------

$host    = 'sql312.byetcluster.com';      // MySQL hostname (vPanel > MySQL Databases)
$db      = 'if0_43189577_sariapp_db';     // Full database name
$user    = 'if0_43189577';                // MySQL username (same as your account username)
$pass    = 'YOUR_VPANEL_PASSWORD';        // <-- put your InfinityFree account (vPanel) password here
$charset = 'utf8mb4';

/*
 * For local XAMPP testing, comment out the 4 lines above and use:
 * $host = 'localhost'; $db = 'sariapp_db'; $user = 'root'; $pass = '';
 */

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Don't expose credentials/details on a live site
    error_log('DB connection failed: ' . $e->getMessage());
    die('Database connection failed. Please check connection.php settings.');
}
