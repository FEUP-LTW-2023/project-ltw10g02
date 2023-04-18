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

  static function getUserById(PDO $db, $id): ?User {

      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE id = ?');

    $stmt->execute(array($id)); 

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

  static function getUser(PDO $db, $login, $password): array {
      $error = '';
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) { 
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE email = ?');
      $stmt->execute(array($login));

      if (!$user = $stmt->fetch()) {
          $error = 'Invalid email';
      }
      
    } else {
      $stmt = $db->prepare('SELECT *
                          FROM users
                          WHERE username = ?');
      $stmt->execute(array($login));
      
      if (!$user = $stmt->fetch()){
        $error = 'Invalid username';
      }
  }

    if (!empty($user) && $user['pass'] === sha1($password)) {
      return array('user' => new User(
        $user['id'],
        $user['name'],
        $user['username'],
        $user['pass'],
        $user['email'],
        $user['category']
      ), 'error'=> 'certinho');
    } else {
        if ($error) {
          return array('user' => null, 'error' => $error);
        } else {
          $error = 'Invalid password' ;
          return array('user' => null, 'error' => $error);
        } 
      }
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

  static function addUser(PDO $db, Session $session, $name, $username, $password, $password_repeated, $email, $category){
    //Check whether username already exist
    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $countUsername = $stmt->fetchColumn();

    //Check whether email already exist
    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute(array($email));
    $countEmail = $stmt->fetchColumn();

    //Whether both don't exist then we insert in database
    if($countUsername === 0 &&  $countEmail === 0){
      if($password === $password_repeated){
        $stmt = $db->prepare('INSERT INTO users (name, username, pass, email, category) VALUES(?, ?, ?, ?, ?)');
        $stmt->execute(array($name, $username, sha1($password), strtolower($email), $category));
        $session->addMessage('success', 'User inserted in the database');
      }
      else{
        $session->addMessage('error', 'Passwords do not match');
      }
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
