<?php
ini_set('display_errors', 1); // Enable error display for debugging
error_reporting(E_ALL); // Report all types of errors

// Include the ClassController to handle class-related operations
require_once __DIR__ . '/../app/controllers/classcontroller.php';

$error_message = '';

try {
    // Instantiate the ClassController
    $controller = new ClassController();

    // Get the requested action from the URL, default to 'index'
    $action = $_GET['action'] ?? 'index';

    // Handle different actions based on user input
    switch ($action) {
        case 'add_class':
            $controller->addClass();
            break;
        case 'delete_class':
            $controller->deleteClass();
            break;
        default:
            $controller->index();
            break;
    }
} catch (Exception $e) {
    // Catch and display errors
    $error_message = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Classes</title>
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
            background-color: #FF5733;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        td a {
            color: #1E90FF;
            text-decoration: none;
        }

        td a:hover {
            color: #FF6347;
        }
    </style>
</head>
<body>

    <h1>Manage Classes</h1>

    <table>
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $class): ?>
                <tr>
                    <td><?= htmlspecialchars($class['name']) ?></td>
                    <td>
                        <a href="edit_class.php?id=<?= $class['id'] ?>">Edit</a> |
                        <a href="delete_class.php?id=<?= $class['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
