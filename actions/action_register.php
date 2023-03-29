<?php
    session_start();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/register.php');
    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    User::addUser($db, $_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'], "client");

    header('Location:' . $_SERVER['HTTP_REFERER']);  // redirect to the page we came from
?>