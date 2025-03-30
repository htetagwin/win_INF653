<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Zippy Used Autos</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #FF5733;
        }

        .container {
            width: 100%;
            padding: 20px;
            margin-top: 30px;
        }

        nav {
            text-align: center;
            margin-bottom: 30px;
        }

        nav a {
            color: #333;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 15px;
            font-size: 16px;
            border-radius: 4px;
            background-color: #e2e2e2;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #FF5733;
            color: white;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 40px;
        }

    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    
    <div class="container">
        <nav>
            <a href="index.php">Manage Vehicles</a>
            <a href="make.php">Manage Makes</a>
            <a href="type.php">Manage Types</a>
            <a href="class.php">Manage Classes</a>
        </nav>
    </div>

</body>
</html>
