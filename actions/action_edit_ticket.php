<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once(__DIR__ . '/../database/database_connection.php');

    require_once(__DIR__ . '/../database/classes/ticket.php');
    $db = getDatabaseConnection();
    
    try {
        $ticket = Ticket::getTicketById($db, $_POST['id']);

        if($session->getCategory() === "client"){
            $ticket->setSubject($_POST['subject']);
            $ticket->setDescription($_POST['description']);
        }
        else{
            if($_POST['field'] === 'department')
                $ticket->setDepartmentId($_POST['fieldId']);
            else if($_POST['field'] === 'agent'){
                $ticket->setAgentId($_POST['fieldId']);
                $ticket->setStatus("Assigned");
            }
            else if($_POST['field'] === 'priority')
                $ticket->setPriority($_POST['fieldValue']);
            else if($_POST['field'] === 'status'){
                if($_POST['fieldValue'] === "Open")
                    $ticket->setAgentId(null);
                $ticket->setStatus($_POST['fieldValue']);
            }
        }

        $ticket->updateTicket($db);

        http_response_code(200);
        $session->addMessage('success', 'Edited ticket.');
    }
    catch (Exception $e) {
        http_response_code(500);
        $session->addMessage('error', $e->getMessage());
        exit();
    }

?>