<?php
    if (isset($_POST['department'], $_POST['description'])) {
	    $department = $_POST['department'];
	    $description = $_POST['description'];

        echo $department;
        echo $description;
    }
?>