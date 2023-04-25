<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/ticket.php';
    require_once __DIR__ . '/../database/classes/comment.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    $ticket = Ticket::getTicketById($db, $_GET['id']);
    $comments = Comment::getAllCommentsByTicketId($db, $ticket->getId());

    drawHeader($session);
    drawTicket($ticket, $comments);
    drawFooter();
?>