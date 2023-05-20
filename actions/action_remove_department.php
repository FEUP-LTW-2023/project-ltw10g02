<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()|| $session->getCategory() !== 'admin'){
        header("Location: ../index.php");
        exit();        
    }

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/user_department.php');

    $db = getDatabaseConnection();

    $userId= isset($_GET['userId']) ? $_GET['userId'] : null;
    $departmentId = isset($_GET['departmentId']) ? $_GET['departmentId'] : null;

    if ($userId && $departmentId) {
        try {
            UserDepartment::removeDepartmentFromUser($db, $userId, $departmentId);
            $session->addMessage('success', 'Department association successfully removed');
        }
        catch (Exception $e) {
            $session->addMessage('error', $e->getMessage());
        }
    }

    header('Location: ../../pages/users.php'); 
    exit();
?>