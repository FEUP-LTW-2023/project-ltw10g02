<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()|| $session->getCategory() !== 'admin'){
        header("Location: ../index.php");
        exit();        
    }

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    $id = $session->getId();

    $userId = isset($_GET['userId']) ? $_GET['userId'] : null;
    $user = User::getUserById($db, $userId);

    if (isset($_POST['category'])) {
        $newCategory = $_POST['category'];
        $user->updateCategory($db, $newCategory);
    }

    header('Location: ../../pages/users.php'); 
    exit();
?>
