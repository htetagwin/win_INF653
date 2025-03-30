<?php include __DIR__ . '/header.php'; ?>
<?php
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
    <title>Available Vehicles</title>
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
        /* Styling for sorting and filtering forms */
        form {
            margin-bottom: 20px;
            display: inline-block;
        }
        select {
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #f9f9f9;
        }
        select:hover {
            background-color: #e9e9e9;
        }
        label {
            font-weight: bold;
            margin-right: 5px;
        }
        .form-container {
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Available Vehicles</h1>

    <!-- Sorting Form -->
    <div class="form-container">
        <form method="get">
            <label for="sort_by">Sort by:</label>
            <select name="sort_by" onchange="this.form.submit()">
                <option value="price" <?= ($sortBy == 'price' ? 'selected' : '') ?>>Price</option>
                <option value="year" <?= ($sortBy == 'year' ? 'selected' : '') ?>>Year</option>
            </select>
        </form>
    </div>

    <!-- Filter Form -->
    <div class="form-container">
        <form method="get">
            <label for="filter">Filter by:</label>
            <select name="filter" onchange="this.form.submit()">
                <option value="">Select a filter</option>
                <option value="make" <?= ($filter == 'make' ? 'selected' : '') ?>>Make</option>
                <option value="type" <?= ($filter == 'type' ? 'selected' : '') ?>>Type</option>
                <option value="class" <?= ($filter == 'class' ? 'selected' : '') ?>>Class</option>
            </select>
            
            <!-- Show filter values only if a filter is selected -->
            <?php if ($filter): ?>
                <label for="filter_value">Value:</label>
                <select name="filter_value" onchange="this.form.submit()">
                    <option value="">Select a value</option>
                    <?php
                    // Display the corresponding filter values based on the selected filter
                    $values = [];
                    if ($filter == 'make') {
                        $values = $makeValues;
                    } elseif ($filter == 'type') {
                        $values = $typeValues;
                    } elseif ($filter == 'class') {
                        $values = $classValues;
                    }
                    foreach ($values as $value): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= ($filter_value == $value ? 'selected' : '') ?>><?= htmlspecialchars($value) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </form>
    </div>

    <!-- Vehicle Table -->
    <div>
        <?php if (empty($vehicles)): ?>
            <p>No vehicles available at the moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Make</th>
                        <th>Type</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td><?= htmlspecialchars($vehicle['model']) ?></td>
                            <td><?= htmlspecialchars($vehicle['year']) ?></td>
                            <td>$<?= number_format($vehicle['price'], 2) ?></td>
                            <td><?= htmlspecialchars($vehicle['make_name']) ?></td>
                            <td><?= htmlspecialchars($vehicle['type_name']) ?></td>
                            <td><?= htmlspecialchars($vehicle['class_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
<?php include __DIR__ . '/footer.php'; ?>
