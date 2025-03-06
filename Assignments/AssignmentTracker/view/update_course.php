<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../model/database.php');
require_once('../model/course_db.php');

$course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
$course = get_course_by_id($course_id);

if (!$course) {
    $error = "Invalid course ID.";
    include('../view/error.php');
    exit();
}
?>

<form action="../index.php" method="post">
    <input type="hidden" name="action" value="update_course">
    <input type="hidden" name="course_id" value="<?= $course['courseID'] ?>">

    <label>Course Name:</label>
    <input type="text" name="course_name" value="<?= htmlspecialchars($course['courseName']) ?>" required>
    <button type="submit">Update Course</button>
</form>