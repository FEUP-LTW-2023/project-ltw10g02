<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn() || $session->getCategory() === 'client')
        header("Location: ../index.php");

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/hashtag.php');
    require_once(__DIR__ . '/../database/classes/ticket_hashtag.php');

    $db = getDatabaseConnection();

    if($_POST['hashtag'] === ''){
        $session->addMessage('error', 'Empty hashtag');
        exit();
    }

    try{
        if(!Hashtag::hashtagExists($db, $_POST['hashtag'])) {
            Hashtag::addHashtag($db, $_POST['hashtag']);
        }
        
        $hashtag = Hashtag::getHashtagByName($db, $_POST['hashtag']);
        TicketHashtag::addTicketHashtag($db, $_POST['ticket_id'], $hashtag->getId());
        http_response_code(200);
        $session->addMessage('success', 'Hashtag added!');
        echo json_encode($hashtag);
        
    }
    catch (Exception $e) {
        http_response_code(500);
        $session->addMessage('error', $e->getMessage());
    }
?>