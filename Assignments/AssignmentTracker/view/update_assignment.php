<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../view/header.php');
require_once('../model/assignment_db.php');
require_once('../model/course_db.php');

$assignment_id = filter_input(INPUT_GET, 'assignment_id', FILTER_VALIDATE_INT);
$assignment = get_assignment_by_id($assignment_id);
$courses = get_courses();

if (!$assignment) {
    echo "Assignment not found!";
    exit();
}
?>

<h2>Update Assignment</h2>
<form action="../index.php" method="post">
    <input type="hidden" name="action" value="update_assignment">
    <input type="hidden" name="assignment_id" value="<?= $assignment['ID'] ?>">

    <label for="description">Description:</label>
    <input type="text" name="description" id="description" value="<?= htmlspecialchars($assignment['Description']) ?>" required>

    <label for="course_id">Course:</label>
    <select name="course_id" id="course_id" required>
        <?php foreach ($courses as $course) : ?>
            <option value="<?= $course['courseID'] ?>" <?= $course['courseID'] == $assignment['courseID'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($course['courseName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Update Assignment</button>
</form>

<?php
include('../view/footer.php');
?>