<?php
declare(strict_types=1);

class Department implements JsonSerializable{
  private $id;
  private $name;
  private $description;

  public function __construct(int $id, string $name, string $description) {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description
    ];
  }

  public function getId(): int {
    return $this->id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getDescription(): string {
    return $this->description;
  }

 
  public static function getDepartmentById(PDO $db, $id): ?Department {

    $stmt = $db->prepare('SELECT *
                        FROM departments
                        WHERE id = ?');

    $stmt->execute(array($id)); 

    if ($department = $stmt->fetch()) {
      return new Department(
        intval($department['id']),
        $department['name'],
        $department['description']
      );
    } else return null;
  }

  public static function getAllDepartments(PDO $db): ?array{
    $departments = array();
    $rows = $db->query('SELECT * FROM departments');
    foreach ($rows as $row) {
      $department = new Department((int) $row['id'], $row['name'], $row['description']);
      $departments[] = $department;
    }
    return $departments;
  }

  // check if department exists
  static function departmentExists(PDO $db, $department_name) {
    $stmt = $db->prepare('SELECT * FROM departments WHERE name = ?');
    $stmt->execute(array($department_name));
    return $stmt->fetch();
  }

  public static function addDepartment(PDO $db, $name, $description){
    $stmt = $db->prepare('INSERT INTO departments (name, description) VALUES(?, ?)');
    return $stmt->execute(array($name, $description));
  }

  
  
}


