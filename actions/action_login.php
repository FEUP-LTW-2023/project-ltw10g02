<?php
    session_start();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $_POST['username'], $_POST['password']);

    if ($user)
        $_SESSION['username'] = $_POST['username']; 
    
    header('Location:' . $_SERVER['HTTP_REFERER']);         // redirect to the page we came from
?>