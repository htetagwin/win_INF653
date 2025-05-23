<?php
require_once __DIR__ . '/../app/controllers/makecontroller.php';

// Instantiate the MakeController
$controller = new MakeController();

// Get the action from the request, default to 'index' if not provided
$action = $_GET['action'] ?? 'index';

// Handle different actions based on user input
switch ($action) {
    case 'add_make':
        $controller->addMake();
        break;
    case 'delete_make':
        $controller->deleteMake();
        break;
    default:
        $controller->index();
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Makes</title>
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

    <h1>Manage Makes</h1>

    <table>
        <thead>
            <tr>
                <th>Make Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($makes as $make): ?>
                <tr>
                    <td><?= htmlspecialchars($make['name']) ?></td>
                    <td>
                        <a href="edit_make.php?id=<?= $make['id'] ?>">Edit</a> |
                        <a href="delete_make.php?id=<?= $make['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
