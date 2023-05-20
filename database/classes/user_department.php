<?php 
class UserDepartment implements JsonSerializable {
    private $user_id;
    private $department_id;
    
    public function __construct($user_id, $department_id) {
      $this->user_id = $user_id;
      $this->department_id = $department_id;
    }

    public function jsonSerialize() {
        return [
          'user_id' => $this->user_id,
          'department_id' => $this->department_id
        ];
    }
  
    public function getUserId() {
      return $this->user_id;
    }
  
    public function setUserId($user_id) {
      $this->user_id = $user_id;
    }
  
    public function getDepartmentId() {
      return $this->department_id;
    }
  
    public function setDepartmentId($department_id) {
      $this->department_id = $department_id;
    }

    public static function getDepartmentsByAgent(PDO $db, $id): ?array{
      $departments = array();

      $stmt = $db->prepare('SELECT * FROM user_department WHERE user_id = ?');
      $stmt->execute(array($id));

      foreach ($stmt as $row) {
        $department = new UserDepartment($row['user_id'], $row['department_id']);
        $departments[] = $department;
      }
      return $departments;
    }

    public static function getAllAgents(PDO $db): ?array{
      $agents = array();
      $rows = $db->query('SELECT DISTINCT user_id FROM user_department');
      foreach ($rows as $row) {
        $agent = new UserDepartment($row['user_id'], null);
        $agents[] = $agent;
      }
      return $agents;
    }
  
    public static function removeDepartmentFromUser(PDO $db, $user_id, $department_id){
      $stmt = $db->prepare('DELETE FROM user_department WHERE user_id = ? AND department_id = ?');
      return $stmt->execute(array($user_id, $department_id));
    }

    public static function addDepartmentToUser(PDO $db, $userId, $departmentId): void
    {
        $stmt = $db->prepare('INSERT INTO user_department (user_id, department_id) VALUES (?, ?)');
        $stmt->execute([$userId, $departmentId]);
    }

    
  }  
?>