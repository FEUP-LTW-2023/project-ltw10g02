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
    require_once (__DIR__ . '/../database/classes/faq.php');

    require_once(__DIR__ . '/../templates/faqs.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    // Retrieve all faqs from the database
    $db = getDatabaseConnection();

    $user = User::getUserById($db, $session->getId());
    $faqs = FAQ::getAll($db);
    
    // Display the FAQs
    drawHeader($session);
    drawFAQs($db, $session, $user, $faqs);
    drawFooter();

?>
