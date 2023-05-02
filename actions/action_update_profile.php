<?php
//tudo errado por enquanto
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    $newName = $_POST['name'];
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPass = $_POST['pass'];

    $user->updateName($db, $newName);
    $user->updateUserame($db, $newUsername);
    $user->updateEmail($db, $newEmail);
    $user->updatePass($db, $newPass);

    header('Location: ../pages/profile.php'); 

?>
