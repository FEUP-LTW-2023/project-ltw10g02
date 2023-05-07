<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn())
        header("Location: ../index.php");

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/user.php');
    require_once(__DIR__ . '/../database/classes/ticket.php');
    require_once(__DIR__ . '/../database/classes/department.php');
    require_once(__DIR__ . '/../database/classes/user_department.php');
    require_once(__DIR__ . '/../database/classes/hashtag.php');

    $db = getDatabaseConnection();
    
    try {
        $ticket = Ticket::getTicketById($db, $_GET['id']);

        $departments = Department::getAllDepartments($db);

        $agents_id = UserDepartment::getAllAgents($db);

        $agents = array();
        foreach ($agents_id as $agent_id) {
            $agent = User::getUserById($db, $agent_id->getUserId());
            $agents[] = $agent;
        }

        $priority = array('Low', 'Medium', 'High');

        $hashtags = Hashtag::getAllHashtags($db);

        echo json_encode(array('department' => $departments, 'agent' => $agents, 'priority' => $priority, 'hashtag' => $hashtags));
        http_response_code(200);
        $session->addMessage('success', 'Edited ticket.');
    }
    catch (Exception $e) {
        http_response_code(500);
        $session->addMessage('error', $e->getMessage());
        exit();
    }

?>