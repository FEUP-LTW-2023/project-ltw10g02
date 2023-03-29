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

  static function getUser(PDO $db, $login, $password): ?User {

    if (filter_var($login, FILTER_VALIDATE_EMAIL)) { 
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE email = ? and pass = ?');
      
    } else {
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE username = ? and pass = ?');
    }

    $stmt->execute(array($login, sha1($password))); 

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

  static function addUser(PDO $db, Session $session, $name, $username, $password, $email, $category){
    //Check whether username already exist
    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $countUsername = $stmt->fetchColumn();

    //Check whether email already exist
    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute(array($email));
    $countEmail = $stmt->fetchColumn();

    //Whether both don't exist then we insert in database
    if($countUsername == 0 &&  $countEmail == 0){
      $stmt = $db->prepare('INSERT INTO users (name, username, pass, email, category) VALUES(?, ?, ?, ?, ?)');
      $stmt->execute(array($name, $username, sha1($password), strtolower($email), $category));
      $session->addMessage('success', 'User inserted in the database');
    }
    elseif($countUsername != 0 && $countEmail == 0){
      $session->addMessage('error', 'Username already exist in the database');
    }
    elseif($countEmail != 0 && $countUsername == 0){
      $session->addMessage('error', 'Email already exist in the database');
    }
    else{
      $session->addMessage('error', 'Username and email already exist in the database');
    }
}
}
?>
