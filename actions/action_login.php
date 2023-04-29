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
        $session->setCategory($user->getCategory());
        $session->addMessage('success', 'Login Successful');
        header('Location: ../index.php');  
    }
    else{
        $session->addMessage('error', 'Login error');
        header('Location:' . $_SERVER['HTTP_REFERER']); 
        exit;
    }
?>