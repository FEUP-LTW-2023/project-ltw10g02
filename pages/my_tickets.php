<?php
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once __DIR__ . '/../utils/util.php';

    require_once __DIR__ . '/../database/database_connection.php';
    require_once __DIR__ . '/../database/classes/ticket.php';
    require_once __DIR__ . '/../database/classes/user_department.php';
    require_once __DIR__ . '/../database/classes/department.php';

    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();

    if($session->getCategory() === "client"){
        $tickets = Ticket::getTicketsByUser($db, $session->getId());
        $departments = array();
        foreach ($tickets as $ticket) {
            $department = Department::getDepartmentById($db, $ticket->getDepartmentId());
            $departments[] = $department;
        }
    }
    else if(($session->getCategory() === "agent")){
        $tickets_agent = Ticket::getTicketsByAgent($db, $session->getId());
        $departments_agent = UserDepartment::getDepartmentsByAgent($db, $session->getId());
        $departments = array();
        foreach ($departments_agent as $department_agent) {
            $department = Department::getDepartmentById($db, $department_agent->getDepartmentId());
            $departments[] = $department;
        }
        $tickets_department = Ticket::getTicketsByDepartments($db, $departments_agent, 'agent');


        $departments_agent_tickets = array();
        foreach ($tickets_agent as $ticket_agent) {
            $department = Department::getDepartmentById($db, $ticket_agent->getDepartmentId());
            $departments_agent_tickets[] = $department;
        }
        $uniqueDepartmentsAgent = getUniqueDepartments($departments_agent_tickets);
    }

    else if($session->getCategory() === "admin"){
        $tickets_admin = Ticket::getTicketsByAgent($db, $session->getId());
        $departments_admin = Department::getAllDepartments($db);

        $tickets_department = Ticket::getTicketsByDepartments($db, $departments_admin, 'admin');


        $departments_admin_tickets = array();
        foreach ($tickets_admin as $ticket_admin) {
            $department = Department::getDepartmentById($db, $ticket_admin->getDepartmentId());
            $departments_admin_tickets[] = $department;
        }

        $uniqueDepartmentsAdmin = getUniqueDepartments($departments_admin_tickets);
    }
    

    $uniqueDepartments = getUniqueDepartments($departments);
    
    drawHeader($session);
    if($session->getCategory() === "client")
        drawTicketsUser($session, $tickets, $uniqueDepartments);
    else if($session->getCategory() === "agent")
        drawTicketsAgent($session, $tickets_agent, $tickets_department, $uniqueDepartments, $uniqueDepartmentsAgent);
    else if($session->getCategory() === "admin")
        drawTicketsAgent($session, $tickets_admin, $tickets_department, $departments_admin, $uniqueDepartmentsAdmin);
    drawFooter();
?>
