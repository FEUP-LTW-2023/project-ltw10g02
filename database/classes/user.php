<?php
declare(strict_types=1);

class User {
  private $id;
  private $name;
  private $username;
  private $pass;
  private $email;
  private $category;

  public function __construct(int $id, string $name, string $username, string $pass, string $email, string $category) {
    $this->id = $id;
    $this->name = $name;
    $this->username = $username;
    $this->pass = $pass;
    $this->email = $email;
    $this->category = $category;
  }

  public function getId(): int {
    return $this->id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getUsername(): string {
    return $this->username;
  }

  public function getPass(): string {
    return $this->pass;
  }

  public function getEmail(): string {
    return $this->email;
  }

  public function getCategory(): string {
    return $this->category;
  }

  static function getUser(PDO $db, $username, $password): ?User {
    $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE username = ? and pass = ?');
    $stmt->execute(array($username, sha1($password)));

    if ($user = $stmt->fetch()) {
      return new User(
        $user['id'],
        $user['name'],
        $user['username'],
        $user['pass'],
        $user['email'],
        $user['category']
      );
    } else return null;
  }

  static function addUser(PDO $db, $name, $username, $password, $email, $category) {
    $stmt = $db->prepare('INSERT INTO users (name, username, pass, email, category) VALUES(?, ?, ?, ?, ?)');
    $stmt->execute(array($name, $username, sha1($password), strtolower($email), $category));
  }
}
?>
