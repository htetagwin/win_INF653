<?php include __DIR__ . '/header.php'; ?>

<h2>Manage Vehicle Classes</h2>

<!-- Add Class Form -->
<form method="POST" action="class.php?action=add_class">
    <input type="text" name="class_name" placeholder="Class Name" required>
    <button type="submit">Add Class</button>
</form>

<!-- Class List Table -->
<table border="1">
    <tr>
        <th>Class Name</th>
        <th>Action</th>
    </tr>
    <?php if (isset($classes) && !empty($classes)): ?>
        <?php foreach ($classes as $class): ?>
        <tr>
            <td><?= htmlspecialchars($class['class_name']); ?></td>
            <td>
                <form method="POST" action="class.php?action=delete_class">
                    <input type="hidden" name="class_id" value="<?= $class['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="2">No classes found.</td></tr>
    <?php endif; ?>
</table>

<?php include __DIR__ . '/footer.php'; ?>
