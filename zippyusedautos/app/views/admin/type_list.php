<?php include __DIR__ . '/header.php'; ?>

<h2>Admin: Manage Types</h2>

<!-- Form to add a new type -->
<form method="POST" action="type.php?action=add_type">
    <input type="text" name="type_name" placeholder="Type Name" required>
    <button type="submit">Add Type</button>
</form>

<!-- Table to display all types -->
<table border="1">
    <tr>
        <th>Type Name</th>
        <th>Action</th>
    </tr>
    <!-- Loop through types and display them -->
    <?php foreach ($types as $type): ?>
    <tr>
        <td><?= $type['type_name'] ?></td>
        <td>
            <!-- Form to delete a type -->
            <form method="POST" action="type.php?action=delete_type">
                <input type="hidden" name="type_id" value="<?= $type['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/footer.php'; ?>
