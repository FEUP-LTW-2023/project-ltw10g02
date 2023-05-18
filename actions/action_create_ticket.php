<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/ticket.php');

    $db = getDatabaseConnection();
    
    try{
        Ticket::addTicket($db, $session, $_POST['subject'], $_POST['description'], $_POST['user_id'], $_POST['department_id']);
        $session->addMessage('success', 'Ticket created!');
        header('Location: ../pages/my_tickets.php'); 
    }
    catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
        header('Location: ../pages/my_tickets.php'); 
    }


?>