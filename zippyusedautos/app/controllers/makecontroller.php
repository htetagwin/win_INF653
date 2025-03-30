<?php
require_once __DIR__ . '/../models/make.php';

class MakeController {
    // Display the list of makes
    public function index() {
        $makes = Make::getAllMakes();
        include __DIR__ . '/../views/admin/make_list.php';
    }

    // Add a new make
    public function addMake() {
        if (!empty($_POST['make_name'])) {
            Make::addMake($_POST['make_name']);
        }
        header("Location: make.php");
    }

    // Delete a make
    public function deleteMake() {
        if (!empty($_POST['make_id'])) {
            Make::deleteMake($_POST['make_id']);
        }
        header("Location: make.php");
    }
}
?>
