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

    if (isset($_POST['name'])) {
        $newName = $_POST['name'];
        $user->updateName($db, $newName);
    }

    header('Location: ../../pages/profile.php'); 
    exit();
?>
