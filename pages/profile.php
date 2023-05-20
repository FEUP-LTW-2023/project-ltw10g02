<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once (__DIR__ . '/../database/database_connection.php');
    require_once (__DIR__ . '/../database/classes/user.php');
    require_once (__DIR__ . '/../database/classes/ticket.php');

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    // Retrieve all tickets from the database
    $db = getDatabaseConnection();

    $user = User::getUserById($db, $session->getId());
    $tickets = Ticket::getTicketsByUser($db, $user->getId(), 3);

    // Display the tickets in an HTML table
    drawHeader($session);
    drawInfosProfile($session, $user, $tickets);
    drawFooter();

?>
