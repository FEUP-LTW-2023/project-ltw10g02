<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/user.php';
    require_once __DIR__ . '/../database/classes/ticket.php';
    require_once __DIR__ . '/../database/classes/comment.php';
    require_once __DIR__ . '/../database/classes/department.php';
    require_once __DIR__ . '/../database/classes/ticket_hashtag.php';
    require_once __DIR__ . '/../database/classes/hashtag.php';
    require_once __DIR__ . '/../database/classes/ticket_history.php';
    require_once __DIR__ . '/../database/classes/faq.php';


    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
  
    $db = getDatabaseConnection();

    $ticket = Ticket::getTicketById($db, $_GET['id']);


    if($session->getId() !== $ticket->getClientId() && $session->getCategory() === "client"){
        $session->addMessage('error', 'You dont have permissions');
        die(header("Location: ../index.php"));
    }

    $comments = Comment::getAllCommentsByTicketId($db, $ticket->getId());
    
    $user_ticket = User::getUserById($db, $ticket->getClientId());

    $agent_ticket = User::getUserById($db, $ticket->getAgentId());

    $department = Department::getDepartmentById($db, $ticket->getDepartmentId());

    $users_comments = array();
    foreach($comments as $comment){
        $user = User::getUserById($db, $comment->getUserId());
        $users_comments[] = $user;
    }

    $ticket_hashtags = TicketHashtag::getByTicketId($db, $ticket->getId());

    $hashtagjoin = "";

    foreach($ticket_hashtags as $ticket_hashtag){
        $hashtag = Hashtag::getTagById($db, $ticket_hashtag->getHashtagId());
        $hashtagjoin .= "#" . $hashtag->getName() . ", ";
    }

    $hashtagjoin = rtrim($hashtagjoin, ", "); // Remove a última vírgula

    $currentPage = "ticket.php";
    drawHeader($session, $currentPage);
    drawTicket($ticket, $session, $comments, $user_ticket, $agent_ticket, $department, $hashtagjoin, $users_comments);    
    drawTicketHistory($db, $ticket -> getId());
    drawFooter();
    
?>