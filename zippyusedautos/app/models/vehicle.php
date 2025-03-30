<?php
require_once 'database.php'; // Ensure database connection is included

class Vehicle {

    // Method to fetch all vehicles with sorting (by price or year)
    public static function getAllVehicles($sortBy = 'price') {
        $pdo = Database::connect();
        
        try {
            $query = "SELECT v.*, m.make_name, t.type_name, c.class_name 
                      FROM vehicles v 
                      JOIN makes m ON v.make_id = m.id
                      JOIN types t ON v.type_id = t.id
                      JOIN classes c ON v.class_id = c.id
                      ORDER BY " . ($sortBy == 'year' ? 'v.year DESC' : 'v.price DESC');
            
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    // Method to fetch vehicles based on filter (make, type, class)
    public static function getVehiclesByFilter($column = null, $value = null, $sortBy = 'price') {
        $pdo = Database::connect();
        
        // If no filter column or value is provided, return all vehicles
        if (!$column || !$value) {
            return self::getAllVehicles($sortBy);
        }
        
        // Map filter names to actual column names in the `vehicles` table
        $columnMap = [
            'make' => 'm.make_name',  // Change v.make_id to m.make_name for LIKE search
            'type' => 't.type_name',
            'class' => 'c.class_name'
        ];
        
        if (!isset($columnMap[$column])) {
            return self::getAllVehicles($sortBy); // If invalid column, return all
        }
        
        $columnName = $columnMap[$column]; // Get the mapped column name
        
        // Construct the query with filtering and sorting by price or year
        $query = "SELECT v.*, m.make_name, t.type_name, c.class_name 
                  FROM vehicles v 
                  JOIN makes m ON v.make_id = m.id
                  JOIN types t ON v.type_id = t.id
                  JOIN classes c ON v.class_id = c.id
                  WHERE $columnName LIKE :value
                  ORDER BY " . ($sortBy == 'year' ? 'v.year DESC' : 'v.price DESC');
        
        // Prepare the statement and bind the filter value with wildcards for LIKE
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':value', '%' . $value . '%', PDO::PARAM_STR); // Use wildcards for LIKE query
        $stmt->execute();
        
        // Fetch and return filtered results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    // Method to get distinct values for filtering (make, type, class)
    public static function getDistinctFilterValues($column) {
        $pdo = Database::connect();

        $validColumns = [
            'make_name' => "SELECT DISTINCT make_name FROM makes",
            'type_name' => "SELECT DISTINCT type_name FROM types",
            'class_name' => "SELECT DISTINCT class_name FROM classes"
        ];

        if (!isset($validColumns[$column])) {
            return [];
        }

        try {
            $stmt = $pdo->prepare($validColumns[$column]);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    // Method to add a new vehicle
    public static function addVehicle($year, $model, $price, $make_id, $type_id, $class_id) {
        $pdo = Database::connect();

        try {
            $query = "INSERT INTO vehicles (year, model, price, make_id, type_id, class_id) 
                      VALUES (:year, :model, :price, :make_id, :type_id, :class_id)";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':year', $year, PDO::PARAM_INT);
            $stmt->bindValue(':model', $model, PDO::PARAM_STR);
            $stmt->bindValue(':price', $price, PDO::PARAM_STR);
            $stmt->bindValue(':make_id', $make_id, PDO::PARAM_INT);
            $stmt->bindValue(':type_id', $type_id, PDO::PARAM_INT);
            $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    // Method to delete a vehicle by its ID
    public static function deleteVehicle($id) {
        $pdo = Database::connect();

        try {
            $stmt = $pdo->prepare("DELETE FROM vehicles WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }
}
?>
