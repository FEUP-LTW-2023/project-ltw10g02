<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $_POST['login'], $_POST['password']);

    if ($user){
        $session->setId($user->getId());
        $session->setName($user->getName());
        header('Location:' . $_SERVER['HTTP_REFERER']);         // redirect to the page we came from
    }
    else{
        header('Location:' . $_SERVER['HTTP_REFERER']); 
    }
?>