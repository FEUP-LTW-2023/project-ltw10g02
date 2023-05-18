<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn() || $session->getCategory() === 'client'){
        header("Location: ../index.php");
        exit();
    }

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/ticket_hashtag.php');

    $db = getDatabaseConnection();

    $jsonData = $_POST['hashtagsIds'];
    $hashtagsIds = json_decode($jsonData);

    try{
        // Agora você pode acessar os elementos do array
        foreach ($hashtagsIds as $hashtagId) {
            TicketHashtag::removeHashtagFromTicket($db, $_POST['ticket_id'], $hashtagId);
        }
        $session->addMessage('success', 'Hashtag removed!');
    }
    catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
    }
?>