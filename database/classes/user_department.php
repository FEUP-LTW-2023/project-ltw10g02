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

    public static function getAllAgents(PDO $db): ?array{
      $agents = array();
      $rows = $db->query('SELECT DISTINCT user_id FROM user_department');
      foreach ($rows as $row) {
        $agent = new UserDepartment($row['user_id'], $row['department_id']);
        $agents[] = $agent;
      }
      return $agents;
    }
  
  }
?>