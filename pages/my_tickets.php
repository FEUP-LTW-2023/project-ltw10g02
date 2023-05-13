<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    if(!$session->isLoggedIn())
        header("Location: ../index.php");

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/ticket.php';
    require_once __DIR__ . '/../database/classes/user_department.php';
    require_once __DIR__ . '/../database/classes/department.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    if($session->getCategory() === "client")
        $tickets = Ticket::getTicketsByUser($db, $session->getId());
    else{
        $tickets_agent = Ticket::getTicketsByAgent($db, $session->getId());
        $departments_agent = UserDepartment::getDeparmentsByAgent($db, $session->getId());
        $tickets_department = Ticket::getTicketsByDepartments($db, $departments_agent);
    }

    $departments = Department::getAllDepartments($db);
    
    drawHeader($session);
    if($session->getCategory() === "client")
        drawTicketsUser($session, $tickets);
    else if($session->getCategory() === "agent")
        drawTicketsAgent($session, $tickets_agent, $tickets_department, $departments);
    drawFooter();
?>
