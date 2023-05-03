<?php
declare(strict_types=1);

class User implements JsonSerializable{
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

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'username' => $this->username,
      'email' => $this->email,
      'category' => $this->category
    ];
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

  static function getUserById(PDO $db, $id): ?User {

    $stmt = $db->prepare('SELECT *
                        FROM users
                        WHERE id = ?');

    $stmt->execute(array($id)); 

    if ($user = $stmt->fetch()) {
      return new User(
        (int) $user['id'],
        $user['name'],
        $user['username'],
        $user['pass'],
        $user['email'],
        $user['category']
      );
    } else return null;
  }
  

  static function getUser(PDO $db, $login, $password): ?User {
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) { 
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE email = ? and pass = ?');
      
    } else {
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE username = ? and pass=?');
      }

    $stmt->execute(array($login, sha1($password))); 

    if ($user = $stmt->fetch()) {
      return new User(
        (int) $user['id'],
        $user['name'],
        $user['username'],
        $user['pass'],
        $user['email'],
        $user['category']
      );
    } else return null;
  }

  function updateName(PDO $db): void {
    $stmt = $db->prepare('
        UPDATE User SET name = ?
        WHERE id = ?
      ');

    $stmt->execute(array($this->name, $this->id));
  }

  function updateUserame(PDO $db): void {
    $stmt = $db->prepare('
        UPDATE User SET username = ?
        WHERE id = ?
      ');

    $stmt->execute(array($this->username, $this->id));
  }
  function updateEmail(PDO $db): void {
    $stmt = $db->prepare('
        UPDATE User SET email = ?
        WHERE id = ?
      ');

    $stmt->execute(array($this->email, $this->id));
  }

  function updatePass(PDO $db): void {
    $stmt = $db->prepare('
        UPDATE User SET pass = ?
        WHERE id = ?
      ');

    $stmt->execute(array($this->pass, $this->id));
  }

  // check if username exists
  static function usernameExists(PDO $db, $username) {
    $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute(array($username));
    return $stmt->fetch();
  }

  // check if email exists
  static function emailExists(PDO $db, $email) {
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute(array($email));
    return $stmt->fetch();
  }

  static function addUser(PDO $db, Session $session, $name, $username, $password, $email, $category){
    $stmt = $db->prepare('INSERT INTO users (name, username, pass, email, category) VALUES(?, ?, ?, ?, ?)');
    return $stmt->execute(array($name, $username, sha1($password), strtolower($email), $category));
  }
}
?>
