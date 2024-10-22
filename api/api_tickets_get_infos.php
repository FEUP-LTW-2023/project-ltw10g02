<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/user.php');
    require_once(__DIR__ . '/../database/classes/ticket.php');
    require_once(__DIR__ . '/../database/classes/department.php');
    require_once(__DIR__ . '/../database/classes/user.php');
    require_once(__DIR__ . '/../database/classes/user_department.php');
    require_once(__DIR__ . '/../database/classes/hashtag.php');
    require_once(__DIR__ . '/../database/classes/ticket_hashtag.php');

    $db = getDatabaseConnection();
    
    try {
        $ticket = Ticket::getTicketById($db, $_GET['id']);

        $status = array('Open', 'Assigned', 'Closed');

        $departments = Department::getAllDepartments($db);

        $agents_id = UserDepartment::getAllAgents($db);

        $agents = User::getAllAgents($db);

        $admins = User::getAllAdmins($db);

        $agents_admins = array_merge($agents, $admins);

        $priority = array('Low', 'Medium', 'High');

        $tickets_hashtags = TicketHashtag::getByTicketId($db, $ticket->getId());

        $hashtags = array();
        foreach ($tickets_hashtags as $ticket_hashtag) {
            $hashtag = HashTag::getTagById($db, $ticket_hashtag->getHashtagId());
            $hashtags[] = $hashtag;
        }

        $allHashtags = Hashtag::getAllHashtags($db);

        echo json_encode(array('status' => $status, 'department' => $departments, 'agent' => $agents_admins, 'priority' => $priority, 'hashtags' => $hashtags, 'allHashtags' => $allHashtags));
        http_response_code(200);
        $session->addMessage('success', 'Edited ticket.');
    }
    catch (Exception $e) {
        http_response_code(500);
        $session->addMessage('error', $e->getMessage());
        exit();
    }

?>