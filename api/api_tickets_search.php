<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if(!$session->isLoggedIn())
        header("Location: ../index.php");

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/ticket.php');
  require_once(__DIR__ . '/../database/classes/user_department.php');

  $db = getDatabaseConnection();

  if($_GET['option'] === '1')
    $tickets = Ticket::searchTickets($db, $session->getId(), $session->getCategory(), $_GET['search']);
  else if($_GET['option'] === '2'){
    $departments_agent = UserDepartment::getDeparmentsByAgent($db, $session->getId());
    $tickets = Ticket::getTicketsByDepartments($db, $departments_agent, $_GET['search']);
  }

  
  echo json_encode($tickets);
?>