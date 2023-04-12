<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/department.php';
    require_once __DIR__ . '/../database/classes/faq.php';
    require_once __DIR__ . '/../database/classes/ticket.php';
    require_once __DIR__ . '/../database/classes/user.php';

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/tickets.tpl.php');


    // Retrieve all tickets from the database
    $db = getDatabaseConnection();
    $tickets = Ticket::getAll($db);


    // Display the tickets in an HTML table
    drawHeader($session);
    drawTickets($db, $tickets);
    drawFooter();

?>
