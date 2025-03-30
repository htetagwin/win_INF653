<?php
require_once 'database.php';

class Type {

    // Method to fetch all types sorted by name
    public static function getAllTypes() {
        $pdo = Database::connect();
        
        // Select all types ordered by type_name in ascending order
        $stmt = $pdo->query("SELECT * FROM types ORDER BY type_name ASC");
        
        // Return all fetched types as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new type
    public static function addType($typeName) {
        $pdo = Database::connect();
        
        // Prepare an INSERT query to add a new type to the database
        $stmt = $pdo->prepare("INSERT INTO types (type_name) VALUES (:type_name)");
        $stmt->bindValue(':type_name', $typeName);
        
        // Execute the statement and return whether it was successful
        return $stmt->execute();
    }

    // Method to delete a type by its ID
    public static function deleteType($id) {
        $pdo = Database::connect();
        
        // Prepare and execute a DELETE query to remove a type by its ID
        $stmt = $pdo->prepare("DELETE FROM types WHERE id = :id");
        $stmt->bindValue(':id', $id);
        
        // Execute and return whether the deletion was successful
        return $stmt->execute();
    }

    // Method to get distinct values for filtering (useful if needed in other scenarios)
    public static function getDistinctTypeValues($column) {
        $pdo = Database::connect();
        
        // Construct the query to get distinct values based on the provided column
        $query = "SELECT DISTINCT $column FROM types";
        
        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        // Fetch and return the distinct values as an array
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
