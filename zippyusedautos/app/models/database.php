<?php
require_once __DIR__ . '/../../config/config.php';

class Database {
    // Static variable to hold the PDO connection
    protected static $pdo;

    // Connects to the database and returns the PDO instance
    public static function connect() {
        // If the connection is not already established
        if (!isset(self::$pdo)) {
            // Create a new PDO instance using the configuration constants
            self::$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

            // Set error handling mode to exception
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        // Return the PDO instance
        return self::$pdo;
    }
}
?>
