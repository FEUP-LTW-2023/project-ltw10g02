<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn())
        header("Location: ../index.php");

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/ticket_hashtag.php');

    $db = getDatabaseConnection();

    try{
        TicketHashtag::removeHashtagFromTicket($db, $_POST['ticket_id'], $_POST['hashtag_id'])
        $session->addMessage('sucess', 'Hashtag removed!');
    }
    catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
    }
?>