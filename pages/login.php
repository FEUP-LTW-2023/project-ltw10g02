<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    require_once(__DIR__ . '/../templates/common.tpl.php');

    drawHeader($session);
    drawLoginForm($session);
    drawFooter();
?>
