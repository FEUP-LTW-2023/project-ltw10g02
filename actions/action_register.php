<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../utils/registerForm.php');

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/user.php');

    $db = getDatabaseConnection();

    if(User::usernameExists($db, $_POST['username']) && User::emailExists($db, $_POST['email'])) {
        $session->addMessage('error', 'Username and email already exists.');
        storeFormValuesAndRedirect($session);
    }

    if(User::emailExists($db, $_POST['email'])) {
        $session->addMessage('error', 'Email already exists.');
        storeFormValuesAndRedirect($session);    
    } 

    if(User::usernameExists($db, $_POST['username'])) {
        $session->addMessage('error', 'Username already exists.');
        storeFormValuesAndRedirect($session);    
    } 

    if($_POST['password'] !== $_POST['password_repeated']) {
        $session->addMessage('error', 'Passwords do not match.');
        storeFormValuesAndRedirect($session);
    }

    if (!preg_match("/^[a-zA-ZÀ-ú\s]+$/", $_POST['name'])) {
        $session->addMessage('error', 'Name must contain only letters and space.');
        storeFormValuesAndRedirect($session);
    }

    if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
        $session->addMessage('error', 'Username must contain only not especial letters and numbers.');
        storeFormValuesAndRedirect($session);
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $session->addMessage('error', 'Invalid email.');
        storeFormValuesAndRedirect($session);
    }
    
    try {
        $user = User::addUser($db, $_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'], "client");
        $session->addMessage('success', 'New user created.');
        header('Location: /../pages/login.php'); 

    } catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
        header('Location: /../pages/register.php'); 
    }

?>