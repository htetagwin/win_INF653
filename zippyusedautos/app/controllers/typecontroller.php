<?php
require_once __DIR__ . '/../models/type.php';

class TypeController {
    // Display the list of types
    public function index() {
        $types = Type::getAllTypes();
        include __DIR__ . '/../views/admin/type_list.php';
    }

    // Add a new type
    public function addType() {
        if (!empty($_POST['type_name'])) {
            Type::addType($_POST['type_name']);
        }
        header("Location: type.php");
    }

    // Delete a type
    public function deleteType() {
        if (!empty($_POST['type_id'])) {
            Type::deleteType($_POST['type_id']);
        }
        header("Location: type.php");
    }
}
?>
