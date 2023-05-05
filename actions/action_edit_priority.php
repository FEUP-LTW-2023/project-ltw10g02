<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn())
        header("Location: ../index.php");

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/ticket.php');

    $db = getDatabaseConnection();
    
    try {
        $ticket = Ticket::getTicketById($db, $_POST['id']);
        $ticket->setPriority($_POST['priority']);

        $ticket->updateTicket($db);

        http_response_code(200);
        $session->addMessage('success', 'Edited priority.');
    }
    catch (Exception $e) {
        http_response_code(500);
        $session->addMessage('error', $e->getMessage());
        exit();
    }
?>