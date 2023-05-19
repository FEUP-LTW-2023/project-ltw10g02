<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
}

require_once(__DIR__ . '/../../database/database_connection.php');
require_once(__DIR__ . '/../../database/classes/user.php');

$db = getDatabaseConnection();

$id = $session->getId();
$user = User::getUserById($db, $id);

if (isset($_POST['old_pass'], $_POST['new_pass'], $_POST['confirm_new_pass'])) {
    $oldPass = $_POST['old_pass'];
    $newPass = $_POST['new_pass'];
    $confirmNewPass = $_POST['confirm_new_pass'];

    if (password_verify($oldPass, $user->getPass())) {
        if ($newPass === $confirmNewPass) {
            $user->updatePass($db, $newPass);
        } else {
            $session->addMessage('error', 'New password and confirmed new password do not match.');
            header("Location: ../../pages/edit_pass.php");
            exit();
        }
    } else {
        $session->addMessage('error', 'Invalid old password.');
        header("Location: ../../pages/edit_pass.php");
        exit();
    }
}

header('Location: ../../pages/profile.php');
