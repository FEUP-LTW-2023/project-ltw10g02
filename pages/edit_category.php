<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn() || $session->getCategory() !== 'admin'){
        header("Location: ../index.php");
        exit();
    }

    require_once (__DIR__ . '/../database/database_connection.php');
    require_once (__DIR__ . '/../database/classes/user.php');
    require_once (__DIR__ . '/../database/classes/user_department.php');
    require_once (__DIR__ . '/../database/classes/department.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/admin.tpl.php');

    $db = getDatabaseConnection();

    // Retrieve clients, agents and admins from the database
    $clients = User::getAllClients($db);
    $agents = User::getAllAgents($db);
    $admins = User::getAllAdmins($db);
    
    $userId = isset($_GET['userId']) ? $_GET['userId'] : null;
 
    // Display all users
    drawHeader($session);

    if ($userId) {
        $user = User::getUserById($db, $userId);
        drawUsersEditCategory($db, $session, $clients, $agents, $admins, $user);
    }

    
    drawFooter();

?>
