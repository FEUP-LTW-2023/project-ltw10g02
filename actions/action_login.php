<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $_POST['login'], $_POST['password']);
    
    if ($user){
        $session->setId($user->getId());
        $session->setName($user->getName());
        header('Location: ../index.php'); 
    }
    else{
        header('Location:' . $_SERVER['HTTP_REFERER']); 
    }
?>