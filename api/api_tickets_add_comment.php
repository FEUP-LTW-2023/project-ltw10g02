<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
  }

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/comment.php');
  require_once(__DIR__ . '/../database/classes/user.php');

  $db = getDatabaseConnection();

  try {
    Comment::addComment($db, $_POST['ticket_id'], $session->getId(), $_POST['comment']);
    $last_comment_id = intval($db->lastInsertId());
    $last_comment = Comment::getCommentById($db, $last_comment_id);
    $user_comment = User::getUserById($db, $last_comment->getUserId());

    http_response_code(200);
    $session->addMessage('success', 'Database updated successfully with the new comment.');
    echo json_encode(array('comment' => $last_comment, 'user' => $user_comment));

  } catch (Exception $e) {
      http_response_code(500);
      $session->addMessage('error', $e->getMessage());
      exit();
  }
?>