<?php include __DIR__ . '/header.php'; ?>

<h2>Admin: Manage Makes</h2>

<!-- Form to add a new make -->
<form method="POST" action="make.php?action=add_make">
    <input type="text" name="make_name" placeholder="Make Name" required>
    <button type="submit">Add Make</button>
</form>

<!-- Table to display all makes -->
<table border="1">
    <tr>
        <th>Make Name</th>
        <th>Action</th>
    </tr>
    <!-- Loop through makes and display them -->
    <?php foreach ($makes as $make): ?>
    <tr>
        <td><?= $make['make_name'] ?></td>
        <td>
            <!-- Form to delete a make -->
            <form method="POST" action="make.php?action=delete_make">
                <input type="hidden" name="make_id" value="<?= $make['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/footer.php'; ?>
