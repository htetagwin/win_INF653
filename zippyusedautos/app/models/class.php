<?php
require_once 'database.php';

class VehicleClass {
    // Method to fetch all vehicle classes sorted by class_name
    public static function getAllClasses() {
        $pdo = Database::connect();
        
        // Select all classes ordered by class_name in ascending order
        $stmt = $pdo->query("SELECT * FROM classes ORDER BY class_name ASC");
        
        // Return all fetched classes as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new class
    public static function addClass($className) {
        $pdo = Database::connect();
        
        // Prepare an INSERT query to add a new class to the database
        $stmt = $pdo->prepare("INSERT INTO classes (class_name) VALUES (:class_name)");
        $stmt->bindValue(':class_name', $className);
        
        // Execute the statement and return whether it was successful
        return $stmt->execute();
    }

    // Method to delete a class by its ID
    public static function deleteClass($id) {
        $pdo = Database::connect();
        
        // Prepare and execute a DELETE query to remove a class by its ID
        $stmt = $pdo->prepare("DELETE FROM classes WHERE id = :id");
        $stmt->bindValue(':id', $id);
        
        // Execute and return whether the deletion was successful
        return $stmt->execute();
    }

    // Method to get vehicle classes based on a filter condition
    public static function getClassesByFilter($filter) {
        $pdo = Database::connect();
        
        // Construct a query with the filter condition, assuming the filter is a part of the class name
        $query = "SELECT * FROM classes WHERE class_name LIKE :filter ORDER BY class_name ASC";
        
        // Prepare the statement and bind the filter value (with wildcards for LIKE)
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':filter', '%' . $filter . '%');
        
        // Execute the query and return the filtered results
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
