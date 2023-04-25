<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/ticket.php');

    $db = getDatabaseConnection();

    Ticket::addTicket($db, $session, $_POST['subject'], $_POST['description'], $_POST['user_id']);

    header('Location: ../pages/my_tickets.php'); 


?>