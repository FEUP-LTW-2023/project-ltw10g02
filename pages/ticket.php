<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/user.php';
    require_once __DIR__ . '/../database/classes/ticket.php';
    require_once __DIR__ . '/../database/classes/comment.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    $ticket = Ticket::getTicketById($db, $_GET['id']);
    $comments = Comment::getAllCommentsByTicketId($db, $ticket->getId());
    
    $user_ticket = User::getUserById($db, $ticket->getClientId());

    $users_comments = array();
    foreach($comments as $comment){
        $user = User::getUserById($db, $comment->getUserId());
        $users_comments[] = $user;
    }

    drawHeader($session);
    drawTicket($ticket, $comments, $user_ticket, $users_comments);
    drawFooter();
?>