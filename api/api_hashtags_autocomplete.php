<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if(!$session->isLoggedIn())
        header("Location: ../index.php");

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/hashtag.php');

  $db = getDatabaseConnection();
  
  $hashtags = Hashtag::searchHashtags($db, $_GET['search']);
  
  echo json_encode($hashtags);
?>