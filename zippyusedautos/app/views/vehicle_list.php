<?php include __DIR__ . '/../../public/header.php'; ?>

<h2>Vehicle Listings</h2>

<!-- Sorting -->
<form method="GET">
    <label>Sort By:</label>
    <select name="sort" onchange="this.form.submit()">
        <option value="price" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price') ? 'selected' : '' ?>>Price (High to Low)</option>
        <option value="year" <?= (isset($_GET['sort']) && $_GET['sort'] == 'year') ? 'selected' : '' ?>>Year (Newest First)</option>
    </select>
</form>

<!-- Filtering -->
<form method="GET">
    <label>Filter by:</label>
    <select name="filter_by" onchange="this.form.submit()">
        <option value="">Select</option>
        <option value="make_id">Make</option>
        <option value="type_id">Type</option>
        <option value="class_id">Class</option>
    </select>

    <select name="filter_value" onchange="this.form.submit()">
        <option value="">Select</option>
        <?php if ($_GET['filter_by'] == 'make_id') foreach ($makes as $make) echo "<option value='{$make['id']}'>{$make['make_name']}</option>"; ?>
        <?php if ($_GET['filter_by'] == 'type_id') foreach ($types as $type) echo "<option value='{$type['id']}'>{$type['type_name']}</option>"; ?>
        <?php if ($_GET['filter_by'] == 'class_id') foreach ($classes as $class) echo "<option value='{$class['id']}'>{$class['class_name']}</option>"; ?>
    </select>
</form>

<!-- Vehicle Table -->
<table border="1">
    <tr>
        <th>Year</th>
        <th>Model</th>
        <th>Price</th>
        <th>Make</th>
        <th>Type</th>
        <th>Class</th>
    </tr>
    <?php foreach ($vehicles as $vehicle): ?>
    <tr>
        <td><?= $vehicle['year'] ?></td>
        <td><?= $vehicle['model'] ?></td>
        <td>$<?= number_format($vehicle['price'], 2) ?></td>
        <td><?= $vehicle['make_name'] ?></td>
        <td><?= $vehicle['type_name'] ?></td>
        <td><?= $vehicle['class_name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../../public/footer.php'; ?>
