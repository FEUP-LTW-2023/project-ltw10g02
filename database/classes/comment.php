<?php
declare(strict_types=1);

class Comment {
  private $id;
  private $ticket_id;
  private $user_id;
  private $body;
  private $updated_at;

  public function __construct(int $id, int $ticket_id, int $user_id, string $body, $updated_at) {
    $this->id = $id;
    $this->ticket_id = $ticket_id;
    $this->user_id = $user_id;
    $this->body = $body;
    $this->updated_at = $updated_at;
  }

  public function getId(): int {
    return $this->id;
  }

  public function getTicketId(): int {
    return $this->ticket_id;
  }

  public function getUserId(): int {
    return $this->user_id;
  }

  public function getBody(): string {
    return $this->body;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }

 
  public static function getCommentById(PDO $db, int $id): ?Comment
  {
      $stmt = $db->prepare('SELECT * FROM comments WHERE id = ?');
      $stmt->execute(array($id));
  
      if ($comment = $stmt->fetch()) {
        return new Comment(
          (int) $comment['id'],
          $comment['ticket_id'],
          $comment['user_id'],
          $comment['body'],
          $comment['updated_at']
        );
      } else return null;
  }

  public static function getAllCommentsByTicketId(PDO $db, int $ticket_id): array{
    $comments = array();

    $stmt = $db->prepare('SELECT * FROM comments WHERE ticket_id = ?');
    $stmt->execute(array($ticket_id));
    $results = $stmt->fetchAll();

    foreach ($results as $result) {
      $comment = new Comment($result['id'], $result['ticket_id'], $result['user_id'], $result['body'], $result['updated_at']);
      $comments[] = $comment;
    }
    return $comments;
  }
  
}


