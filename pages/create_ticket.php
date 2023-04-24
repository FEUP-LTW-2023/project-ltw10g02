<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    require_once(__DIR__ . '/../templates/common.tpl.php');

    require_once(__DIR__ . '/../templates/tickets.tpl.php');

    drawHeader($session);
    drawTicketForm($session);
    drawFooter();
?>
