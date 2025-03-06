<?php
require('model/database.php');
require('model/assignment_db.php');
require('model/course_db.php');

$assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
$course_name = filter_input(INPUT_POST, 'course_name', FILTER_SANITIZE_SPECIAL_CHARS);
$course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);

if (!$course_id) {
    $course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list_assignments';
}

switch ($action) {
    case "list_courses":
        $courses = get_courses();
        include('view/course_list.php');
        break;

    case "add_course":
        if ($course_name) {
            add_course($course_name);
            header("Location: .?action=list_courses");
        } else {
            $error = "Invalid course data.";
            include('view/error.php');
        }
        break;

    case "update_course":  // ✅ New Case for Updating a Course
        if ($course_id && $course_name) {
            update_course($course_id, $course_name);
            header("Location: .?action=list_courses");
        } else {
            $error = "Invalid course data. Please check all fields.";
            include('view/error.php');
        }
        break;

    case "add_assignment":
        if ($course_id && $description) {
            add_assignment($course_id, $description);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Invalid assignment data. Check all fields and try again.";
            include('view/error.php');
        }
        break;

    case "delete_course":
        if ($course_id) {
            try {
                delete_course($course_id);
            } catch (PDOException $e) {
                $error = "You cannot delete a course if assignments exist for it.";
                include('view/error.php');
                exit();
            }
            header("Location: .?action=list_courses");
        }
        break;

    case "delete_assignment":
        if ($assignment_id) {
            delete_assignment($assignment_id);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Missing or incorrect assignment ID.";
            include('view/error.php');
        }
        break;

    case "update_assignment":
        if ($assignment_id && $description && $course_id) {
            update_assignment($assignment_id, $description, $course_id);
            header("Location: index.php");
        } else {
            $error = "Invalid assignment data.";
            include('view/error.php');
        }
        break;

    default:
        $course_name = get_course_name($course_id);
        $courses = get_courses();
        $assignments = get_assignments_by_course($course_id);
        include('view/assignment_list.php');
}
?>
