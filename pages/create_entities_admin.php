<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    if(!$session->isLoggedIn() || $session->getCategory() !== 'admin'){
        header("Location: ../index.php");
        exit();
    }

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/admin.tpl.php');

    drawHeader($session);
    addElementsAdmin($session);
    drawFooter();
?>