<?php
    session_start();

    require_once(__DIR__ . '/../templates/common.tpl.php');

    drawHeader();
    drawRegisterForm();
    drawFooter();
?>