<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    if(!$session->isLoggedIn())
        header("Location: ../index.php");

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/ticket.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    if($session->getCategory() === "client")
        $tickets = Ticket::getTicketsByUser($db, $session->getId());
    else{
        /* $user = User::getUserById($db, $session->getId()); */
        $tickets = Ticket::getTicketsByAgent($db, $session->getId());
        /* $tickets_department = Ticket::getTicketsByDepartment($db, $tickets->getDepartmentId()); */
    }
    
    drawHeader($session);
    drawTicketsUser($session, $tickets);
    drawFooter();
?>
