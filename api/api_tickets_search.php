<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
  }

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/ticket.php');
  require_once(__DIR__ . '/../database/classes/user_department.php');
  require_once(__DIR__ . '/../database/classes/department.php');

  $db = getDatabaseConnection();

  if($_GET['option'] === '1'){
    if($session->getCategory() === "client")
      $tickets = Ticket::getTicketsByUser($db, $session->getId());
    else
      $tickets = Ticket::getTicketsByAgent($db, $session->getId());

    $departments = array();
    foreach ($tickets as $ticket) {
        $department = Department::getDepartmentById($db, $ticket->getDepartmentId());
        $departments[] = $department;
    }

    $search_tickets = Ticket::searchTickets($db, $session->getId(), $session->getCategory(), $departments, $_GET['search'], $_GET['department'], $_GET['status'], $_GET['priority']);
    
  }
  else if($_GET['option'] === '2'){
    if($session->getCategory() === "agent"){
      $departments_agent = UserDepartment::getDeparmentsByAgent($db, $session->getId());
      $search_tickets = Ticket::searchTickets($db, $session->getId(), '', $departments_agent, $_GET['search'], $_GET['department'], $_GET['status'], $_GET['priority']);
    }
    else{
      $departments_admin = Department::getAllDepartments($db);
      $search_tickets = Ticket::searchTickets($db, $session->getId(), $session->getCategory(), $departments_admin, $_GET['search'], $_GET['department'], $_GET['status'], $_GET['priority']);
    }
  }

  
  echo json_encode($search_tickets);
?>