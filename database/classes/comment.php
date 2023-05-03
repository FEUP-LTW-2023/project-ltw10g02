<?php
declare(strict_types=1);

class Comment implements JsonSerializable{
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

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'ticket_id' => $this->ticket_id,
      'user_id' => $this->user_id,
      'body' => $this->body,
      'updated_at' => $this->updated_at
    ];
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
      $comment = new Comment((int) $result['id'], (int) $result['ticket_id'], (int) $result['user_id'], $result['body'], $result['updated_at']);
      $comments[] = $comment;
    }
    return $comments;
  }

  static function addComment(PDO $db, $ticket_id, $user_id, $body) {
    $stmt = $db->prepare('INSERT INTO comments (ticket_id, user_id, body) VALUES(?, ?, ?)');
    return $stmt->execute(array($ticket_id, $user_id, $body));
  }

  
}


