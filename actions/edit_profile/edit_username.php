<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../../index.php");
        exit();        
    }

    require_once(__DIR__ . '/../../database/database_connection.php');
    require_once(__DIR__ . '/../../database/classes/user.php');

    $db = getDatabaseConnection();

    $id = $session->getId();
    $user = User::getUserById($db, $id);

    if (isset($_POST['username'])) {
        if(User::usernameExists($db, $_POST['username'])) {
            $session->addMessage('error', 'Username already exists.');
            header("Location: ../../pages/edit_username.php");    
            exit();
        }
        else {
            $newUsername = $_POST['username'];
            $user->updateUsername($db, $newUsername);
        } 
    }

    header('Location: ../../pages/profile.php'); 
    exit();
?>
