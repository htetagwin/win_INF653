<?php
require_once __DIR__ . '/../models/vehicle.php';

class PublicController {
    public function index() {
        // Check if a sort option is provided (default is 'price')
        $sortBy = $_GET['sort_by'] ?? 'price';

        // Check if a filter is applied (make, type, class)
        $filter = $_GET['filter'] ?? null;
        $filter_value = $_GET['filter_value'] ?? null;

        // Map filters to their actual column names
        $filterColumns = [
            'make' => 'make_name',
            'type' => 'type_name',
            'class' => 'class_name'
        ];

        // If a filter is provided, validate and map it to the correct column
        if ($filter && $filter_value && isset($filterColumns[$filter])) {
            // Get the vehicles based on the filter
            $vehicles = Vehicle::getVehiclesByFilter($filterColumns[$filter], $filter_value, $sortBy);
        } else {
            // Get all vehicles sorted by price or year
            $vehicles = Vehicle::getAllVehicles($sortBy);
        }

        // Include the view to display vehicles (make sure to pass $vehicles to the view)
        include __DIR__ . '/../views/public/index.php';
    }
}
