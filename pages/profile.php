<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/user.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    // Retrieve all tickets from the database
    $db = getDatabaseConnection();

    $user = User::getUserInfosById($db, $session->getId());

    // Display the tickets in an HTML table
    drawHeader($session);
    drawInfosProfile($user);
    drawFooter();

?>
