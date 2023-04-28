<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/comment.php');

  $db = getDatabaseConnection();

  try {
    Comment::addComment($db, $_POST['ticket_id'], $session->getId(), $_POST['comment']);
    $session->addMessage('success', 'Database updated successfully with the new comment.');
  } catch (Exception $e) {
      header('HTTP/1.1 500 Internal Server Error');
      $session->addMessage('error', $e->getMessage());
      exit();
  }
?>