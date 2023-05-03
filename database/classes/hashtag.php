<?php 
class Hashtag implements JsonSerializable {
    private $id;
    private $name;
    
    public function __construct($id, $name) {
      $this->id = $id;
      $this->name = $name;
    }

    public function jsonSerialize() {
        return [
          'id' => $this->id,
          'name' => $this->name,
        ];
      }
    
    public function getId() {
      return $this->id;
    }
    
    public function getName() {
      return $this->name;
    }
    
    static function getTagById(PDO $db, $id): ?Hashtag {

        $stmt = $db->prepare('SELECT *
                            FROM hashtags
                            WHERE id = ?');
    
        $stmt->execute(array($id)); 
    
        if ($hashtag = $stmt->fetch()) {
          return new Hashtag(
            (int) $hashtag['id'],
            $hashtag['name']
          );
        } else return null;
      }

  }




?>