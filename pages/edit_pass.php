<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn() || $session->getCategory() !== 'client')
        header("Location: ../index.php");

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/user.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    $user = User::getUserById($db, $session->getId());

    drawHeader($session);
    drawEditPassForm($session, $user);
    drawFooter();

?>
