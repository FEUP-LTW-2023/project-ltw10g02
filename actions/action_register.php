<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    User::addUser($db, $session, $_POST['name'], $_POST['username'], $_POST['password'], $_POST['password_repeated'], $_POST['email'], "client");

    if($session->getMessages()['type'] === 'sucess')
        header('Location: /../pages.login.php' );  // redirect to the page we came from
    else{
        $session->addMessage('data', $_POST['name']);
        $session->addMessage('data', $_POST['username']);
        $session->addMessage('data', $_POST['email']);
        header('Location: /../pages/register.php');

    }

?>