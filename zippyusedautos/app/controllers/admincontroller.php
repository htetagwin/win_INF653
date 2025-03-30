<?php
require_once __DIR__ . '/../models/vehicle.php';
require_once __DIR__ . '/../models/make.php';
require_once __DIR__ . '/../models/type.php';
require_once __DIR__ . '/../models/class.php';

class AdminController {
    // Display the main admin dashboard with vehicle listings
    public function index() {
        $vehicles = Vehicle::getAllVehicles(); // Fetch all vehicles
        $makes = Make::getAllMakes(); // Fetch all makes
        $types = Type::getAllTypes(); // Fetch all types
        $classes = VehicleClass::getAllClasses(); // Fetch all classes

        // Include the view file that displays the vehicle list
        include __DIR__ . '/../views/admin/vehicle_list.php';
    }

    // Add a new vehicle to the database
    public function addVehicle() {
        // Ensure all required form fields are filled before adding
        if (!empty($_POST['year']) && !empty($_POST['model']) && !empty($_POST['price']) &&
            !empty($_POST['make_id']) && !empty($_POST['type_id']) && !empty($_POST['class_id'])) {
            
            // Call the model method to insert the vehicle data
            Vehicle::addVehicle($_POST['year'], $_POST['model'], $_POST['price'], $_POST['make_id'], $_POST['type_id'], $_POST['class_id']);
        }

        // Redirect back to the main admin page after adding
        header("Location: index.php");
    }

    // Delete a vehicle from the database
    public function deleteVehicle() {
        // Ensure a vehicle ID is provided before attempting to delete
        if (!empty($_POST['vehicle_id'])) {
            Vehicle::deleteVehicle($_POST['vehicle_id']); // Call the model method to delete the vehicle
        }

        // Redirect back to the main admin page after deletion
        header("Location: index.php");
    }
}
?>
