<?php
require_once 'database.php';

class Make {
    // Method to fetch all makes sorted by make_name
    public static function getAllMakes() {
        $pdo = Database::connect();
        
        // Select all makes ordered by make_name in ascending order
        $stmt = $pdo->query("SELECT * FROM makes ORDER BY make_name ASC");
        
        // Return all fetched makes as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new make
    public static function addMake($makeName) {
        $pdo = Database::connect();
        
        // Prepare an INSERT query to add a new make to the database
        $stmt = $pdo->prepare("INSERT INTO makes (make_name) VALUES (:make_name)");
        $stmt->bindValue(':make_name', $makeName);
        
        // Execute the statement and return whether it was successful
        return $stmt->execute();
    }

    // Method to delete a make by its ID
    public static function deleteMake($id) {
        $pdo = Database::connect();
        
        // Prepare and execute a DELETE query to remove a make by its ID
        $stmt = $pdo->prepare("DELETE FROM makes WHERE id = :id");
        $stmt->bindValue(':id', $id);
        
        // Execute and return whether the deletion was successful
        return $stmt->execute();
    }

    // Method to get makes based on a filter condition
    public static function getMakesByFilter($filter) {
        $pdo = Database::connect();
        
        // Construct a query with the filter condition, assuming the filter is a part of the make name
        $query = "SELECT * FROM makes WHERE make_name LIKE :filter ORDER BY make_name ASC";
        
        // Prepare the statement and bind the filter value (with wildcards for LIKE)
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':filter', '%' . $filter . '%');
        
        // Execute the query and return the filtered results
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
