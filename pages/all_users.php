<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once (__DIR__ . '/../database/database_connection.php');
    require_once (__DIR__ . '/../database/classes/user.php');
    require_once (__DIR__ . '/../templates/users.tpl.php');

    $db = getDatabaseConnection();

    $user = User::getUserById($db, $session->getId());

    drawHeader($session);
    drawUsers($user);
    drawFooter();
?>