<?php
require_once __DIR__ . '/../models/class.php';

class ClassController {
    // Display the list of all vehicle classes
    public function index() {
        $classes = VehicleClass::getAllClasses(); // Fetch all classes from the model
        include __DIR__ . '/../views/admin/class_list.php'; // Load the view for displaying classes
    }

    // Add a new vehicle class to the database
    public function addClass() {
        // Ensure the class name is provided before adding
        if (!empty($_POST['class_name'])) {
            VehicleClass::addClass($_POST['class_name']); // Call the model method to insert the class
        }
        
        // Redirect back to the class management page
        header("Location: class.php");
    }

    // Delete an existing vehicle class
    public function deleteClass() {
        // Ensure a class ID is provided before attempting deletion
        if (!empty($_POST['class_id'])) {
            VehicleClass::deleteClass($_POST['class_id']); // Call the model method to delete the class
        }
        
        // Redirect back to the class management page
        header("Location: class.php");
    }
}
?>
