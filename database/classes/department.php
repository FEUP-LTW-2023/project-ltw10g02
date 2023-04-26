<?php
declare(strict_types=1);

class Department {
  private $id;
  private $name;
  private $description;

  public function __construct(int $id, string $name, string $description) {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
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

 
  public static function getById(PDO $db, int $id): ?Department
  {
      $stmt = $db->prepare('SELECT * FROM departments WHERE id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_OBJ);
  
      try {
          $departmentData = $stmt->fetch();
          if (!$departmentData) {
              return null;
          }
          $department = new Department(
              (int)$departmentData->id,
              $departmentData->name,
              $departmentData->description
          );
          return $department;
      } catch(PDOException $e) {
          // Handle the error
          error_log($e->getMessage());
          return null;
      }
  }

  public static function getAllDepartments(PDO $db): array{
    $departments = array();
    $rows = $db->query('SELECT * FROM departments');
    foreach ($rows as $row) {
      $department = new Department((int) $row['id'], $row['name'], $row['description']);
      $departments[] = $department;
    }
    return $departments;
  }
  
}


