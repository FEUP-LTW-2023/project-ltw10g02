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

  static function getAllUsers(PDO $db): ?array {
    $users = array();
    $stmt = $db->prepare('SELECT * FROM users');

    $stmt->execute(); 
    foreach ($stmt as $row){
      $user = new User(
        (int) $row['id'],
        $row['name'],
        $row['username'],
        $row['pass'],
        $row['email'],
        $row['category']
      );

      $users[] = $user;
    }

    return $users;
  }
  
  static function getAllClients(PDO $db): ?array {
    $users = array();
    $stmt = $db->prepare('SELECT * FROM users WHERE category = "client"');
    $stmt->execute();

    foreach ($stmt as $row){
      $user = new User(
        (int) $row['id'],
        $row['name'],
        $row['username'],
        $row['pass'],
        $row['email'],
        $row['category']
      );

      $users[] = $user;
    }

    return $users;
  }

  static function getAllAgents(PDO $db): ?array {
    $users = array();
    $stmt = $db->prepare('SELECT * FROM users WHERE category = "agent"');
    $stmt->execute();

    foreach ($stmt as $row){
      $user = new User(
        (int) $row['id'],
        $row['name'],
        $row['username'],
        $row['pass'],
        $row['email'],
        $row['category']
      );

      $users[] = $user;
    }

    return $users;
  }

  static function getAllAdmins(PDO $db): ?array {
    $users = array();
    $stmt = $db->prepare('SELECT * FROM users WHERE category = "admin"');
    $stmt->execute();

    foreach ($stmt as $row){
      $user = new User(
        (int) $row['id'],
        $row['name'],
        $row['username'],
        $row['pass'],
        $row['email'],
        $row['category']
      );

      $users[] = $user;
    }

    return $users;
  }

  static function getUser(PDO $db, $login, $password): ?User {
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) { 
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE email = ?');
      
    } else {
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE username = ?');
    }
  
    $stmt->execute(array($login));
  
    if ($user = $stmt->fetch()) {
      $hashedPassword = $user['pass'];
      if (password_verify($password, $hashedPassword)) {
        return new User(
          (int) $user['id'],
          $user['name'],
          $user['username'],
          $user['pass'],
          $user['email'],
          $user['category']
        );
      }
    }
  
    return null;
  }
  

  function updateName(PDO $db, string $newName): void {
    $stmt = $db->prepare('
        UPDATE users SET name = ?
        WHERE id = ?
      ');

    $result = $stmt->execute(array($newName, $this->id));
    if ($result) {
      $this->name = $newName;
    }
  }

  function updateUsername(PDO $db, string $newUsername): void {
    $stmt = $db->prepare('
        UPDATE users SET username = ?
        WHERE id = ?
      ');

    $result = $stmt->execute(array($newUsername, $this->id));
    if ($result) {
      $this->username = $newUsername;
    }
  }

  function updateEmail(PDO $db, string $newEmail): void {
    $stmt = $db->prepare('
        UPDATE users SET email = ?
        WHERE id = ?
      ');

    $result = $stmt->execute(array(strtolower($newEmail), $this->id));
    if ($result) {
      $this->email = strtolower($newEmail);
    }
  }

  function updatePass(PDO $db, string $newPass): void {
    $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
    
    $stmt = $db->prepare('
      UPDATE users SET pass = ?
      WHERE id = ?
    ');
  
    $result = $stmt->execute(array($hashedPassword, $this->id));
    if ($result) {
      $this->pass = $hashedPassword;
    }
  }
  

  function updateCategory(PDO $db, string $newCategory): void {
    $stmt = $db->prepare('
        UPDATE users SET category = ?
        WHERE id = ?
      ');

    $result = $stmt->execute(array($newCategory, $this->id));
    if ($result) {
      $this->category = $newCategory;
    }
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

  static function addUser(PDO $db, $name, $username, $password, $email, $category){
    $stmt = $db->prepare('INSERT INTO users (name, username, pass, email, category) VALUES(?, ?, ?, ?, ?)');
    return $stmt->execute(array($name, $username, password_hash($password, PASSWORD_DEFAULT), strtolower($email), $category));
  }
}
?>
