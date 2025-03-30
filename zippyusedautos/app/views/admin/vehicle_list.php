<?php include __DIR__ . '/header.php'; ?>

<h2>Admin: Manage Vehicles</h2>

<!-- Add Vehicle Form -->
<form method="POST" action="index.php?action=add_vehicle">
    <input type="text" name="year" placeholder="Year" required>
    <input type="text" name="model" placeholder="Model" required>
    <input type="text" name="price" placeholder="Price" required>

    <select name="make_id" required>
        <option value="">Select Make</option>
        <?php foreach ($makes as $make) echo "<option value='{$make['id']}'>{$make['make_name']}</option>"; ?>
    </select>

    <select name="type_id" required>
        <option value="">Select Type</option>
        <?php foreach ($types as $type) echo "<option value='{$type['id']}'>{$type['type_name']}</option>"; ?>
    </select>

    <select name="class_id" required>
        <option value="">Select Class</option>
        <?php foreach ($classes as $class) echo "<option value='{$class['id']}'>{$class['class_name']}</option>"; ?>
    </select>

    <button type="submit">Add Vehicle</button>
</form>

<!-- Vehicle List -->
<table border="1">
    <tr>
        <th>Year</th>
        <th>Model</th>
        <th>Price</th>
        <th>Make</th>
        <th>Type</th>
        <th>Class</th>
        <th>Action</th>
    </tr>
    <?php foreach ($vehicles as $vehicle): ?>
    <tr>
        <td><?= $vehicle['year'] ?></td>
        <td><?= $vehicle['model'] ?></td>
        <td>$<?= number_format($vehicle['price'], 2) ?></td>
        <td><?= $vehicle['make_name'] ?></td>
        <td><?= $vehicle['type_name'] ?></td>
        <td><?= $vehicle['class_name'] ?></td>
        <td>
            <form method="POST" action="index.php?action=delete_vehicle">
                <input type="hidden" name="vehicle_id" value="<?= $vehicle['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/footer.php'; ?>
