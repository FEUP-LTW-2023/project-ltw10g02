<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if(!$session->isLoggedIn() || $session->getCategory() === 'client'){
        header("Location: ../index.php");
        exit();
  }

  require_once(__DIR__ . '/../database/database_connection.php');
  require_once(__DIR__ . '/../database/classes/hashtag.php');

  $db = getDatabaseConnection();
  
  $hashtags = Hashtag::searchHashtags($db, $_GET['search']);
  
  echo json_encode($hashtags);
?>