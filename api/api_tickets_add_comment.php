<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/comment.php');

  $db = getDatabaseConnection();

  Comment::addComment($db, $_POST['ticket_id'], $session->getId(), $_POST['comment']);
?>