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
    
    $user = User::addUser($db, $session, $_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'], "client");

    if($user){
        $session->addMessage('success', 'New user created.');
        header('Location: /../pages/login.php');  // redirect to the page we came from
    }

?>