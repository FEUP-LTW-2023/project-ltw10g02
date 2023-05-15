<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn() || $session->getCategory() !== 'admin')
        header("Location: ../index.php");

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/department.php');

    $db = getDatabaseConnection();

    Department::addDepartment($db, $_POST['name'], $_POST['description']);

    header('Location: ../pages/admin_area.php'); 
?>