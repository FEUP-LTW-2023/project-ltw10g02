<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once __DIR__ . '/../database/database_connection.php';
    require_once(__DIR__ . '/../database/classes/department.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/tickets.tpl.php');

    $db = getDatabaseConnection();

    $departments = Department::getAllDepartments($db);

    drawHeader($session);
    drawTicketForm($session, $departments);
    drawFooter();
?>
