<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../utils/registerForm.php');

    if(!$session->isLoggedIn() || $session->getCategory() !== 'admin')
        header("Location: ../index.php");

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/department.php');

    $db = getDatabaseConnection();

    if(Department::departmentExists($db, $_POST['name_department'])){
        $session->addMessage('error', 'Department already exists.');
        departmentRedirect($session);    
    }


    Department::addDepartment($db, $_POST['name_department'], $_POST['description_department']);
    $session->addMessage('sucess', 'Department created!');

    header('Location: ../pages/create_entities_admin.php'); 
?>