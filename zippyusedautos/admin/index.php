<?php
require_once __DIR__ . '/../app/controllers/admincontroller.php';

$controller = new AdminController();

// Default action
$action = $_GET['action'] ?? 'index';

// Handle the action
switch ($action) {
    case 'add_vehicle':
        $controller->addVehicle();
        break;
    case 'delete_vehicle':
        $controller->deleteVehicle();
        break;
    default:
        $controller->index();
        break;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/models/vehicle.php';

// Get the sorting option (default is price)
$sortBy = isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['price', 'year']) ? $_GET['sort_by'] : 'price';

// Get the filter and filter_value from GET parameters
$filter = $_GET['filter'] ?? null;
$filter_value = $_GET['filter_value'] ?? null;

// Fetch all vehicles or filtered vehicles based on the filter
$vehicles = Vehicle::getVehiclesByFilter($filter, $filter_value, $sortBy);

// Fetch distinct filter values for each filter category (make, type, class)
$makeValues = Vehicle::getDistinctFilterValues('make_name');
$typeValues = Vehicle::getDistinctFilterValues('type_name');
$classValues = Vehicle::getDistinctFilterValues('class_name');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Available Vehicles</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #FF5733; /* Vibrant Red */
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2; /* Light gray for alternating rows */
    }
    tr:nth-child(odd) {
        background-color: #ffe6e6; /* Soft pink for odd rows */
    }
    td {
        font-size: 14px;
        color: #333;
    }
    td a {
        color: #1E90FF; /* Bright Blue for links */
        text-decoration: none;
    }
    td a:hover {
        color: #FF6347; /* Tomato color on hover */
    }
</style>
</head>
</html>
