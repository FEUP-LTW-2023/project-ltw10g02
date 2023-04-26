<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/ticket.php');

  $db = getDatabaseConnection();

  $tickets = Ticket::searchTicketsUser($db, $session->getId(), $_GET['search']);

  echo json_encode($tickets);
?>