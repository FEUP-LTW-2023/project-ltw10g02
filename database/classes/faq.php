<?php
declare(strict_types=1);

class FAQ {
  private $id;
  private $question;
  private $answer;

  public function __construct(string $question, string $answer, int $id = null) {
    $this->id = $id;
    $this->question = $question;
    $this->answer = $answer;
  }

  public static function getById(PDO $db, int $id): ?self {
    $stmt = $db->prepare('SELECT * FROM faqs WHERE id = ?');
    $stmt->execute([$id]);
    $result = $stmt->fetch();

    if (!$result) {
      return null;
    }

    return new self($result['question'], $result['answer'], $result['id']);
  }

  public static function getAll(PDO $db): array {
    $stmt = $db->prepare('SELECT * FROM faqs');
    $stmt->execute();
    $results = $stmt->fetchAll();

    $faqs = [];
    foreach ($results as $result) {
      $faqs[] = new self($result['question'], $result['answer'], $result['id']);
    }

    return $faqs;
  }

  public function save(PDO $db): void {
    if ($this->id) {
      $stmt = $db->prepare('UPDATE faqs SET question = ?, answer = ? WHERE id = ?');
      $stmt->execute([$this->question, $this->answer, $this->id]);
    } else {
      $stmt = $db->prepare('INSERT INTO faqs (question, answer) VALUES (?, ?)');
      $stmt->execute([$this->question, $this->answer]);
      $this->id = $db->lastInsertId();
    }
  }

  public function delete(): void {
    if (!$this->id) {
      return;
    }

    $db = getDatabaseConnection();
    $stmt = $db->prepare('DELETE FROM faqs WHERE id = ?');
    $stmt->execute([$this->id]);
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getQuestion(): string {
    return $this->question;
  }

  public function setQuestion(string $question): void {
    $this->question = $question;
  }

  public function getAnswer(): string {
    return $this->answer;
  }

  public function setAnswer(string $answer): void {
    $this->answer = $answer;
  }
}
