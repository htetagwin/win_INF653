<?php
require_once __DIR__ . '/../models/vehicle.php';
require_once __DIR__ . '/../models/make.php';
require_once __DIR__ . '/../models/type.php';
require_once __DIR__ . '/../models/class.php';

class VehicleController {
    // Displays a list of vehicles, sorted and optionally filtered
    public function index() {
        // Default sorting by price, or use the sort query parameter
        $sortBy = $_GET['sort'] ?? 'price';  

        // Optional filter parameters
        $filterBy = $_GET['filter_by'] ?? null;
        $filterValue = $_GET['filter_value'] ?? null;

        // Get vehicles based on filter or sorting criteria
        if ($filterBy && $filterValue) {
            $vehicles = Vehicle::getVehiclesByFilter($filterBy, $filterValue);
        } else {
            $vehicles = Vehicle::getAllVehicles($sortBy);
        }

        // Fetch makes, types, and classes for filtering options
        $makes = Make::getAllMakes();
        $types = Type::getAllTypes();
        $classes = VehicleClass::getAllClasses();

        // Include the view to display the vehicle list
        include __DIR__ . '/../views/vehicle_list.php';
    }
}
?>
