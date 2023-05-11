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

    if (isset($_POST['email'])) {
        if(User::emailExists($db, $_POST['email'])) {
            $session->addMessage('error', 'Email already used.');
            header("Location: ../../pages/edit_email.php");    
            exit();
        }
        else {
            $newEmail = $_POST['email'];
            $user->updateEmail($db, $newEmail);
        } 
    }

    header('Location: ../../pages/profile.php'); 
    exit();
?>
