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

    static function getHashtagByName(PDO $db, $name): ?Hashtag {

      $stmt = $db->prepare('SELECT *
                          FROM hashtags
                          WHERE name = ?');
  
      $stmt->execute(array($name)); 
  
      if ($hashtag = $stmt->fetch()) {
        return new Hashtag(
          (int) $hashtag['id'],
          $hashtag['name']
        );
      } else return null;
  }

    public static function getAllHashtags(PDO $db): ?array{
      $hashtags = array();
      $rows = $db->query('SELECT * FROM hashtags');
      foreach ($rows as $row) {
        $hashtag = new Hashtag($row['id'], $row['name']);
        $hashtags[] = $hashtag;
      }
      return $hashtags;
    }

    public static function searchHashtags(PDO $db, string $search): array {
      $hashtags = array();
  
      $stmt = $db->prepare('SELECT * FROM hashtags WHERE name LIKE ?');
      $stmt->execute(array($search . '%'));
      
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($rows as $row) {
          $hashtag = new Hashtag($row['id'], $row['name']);
          $hashtags[] = $hashtag;
      }
  
      return $hashtags;
    }

    // check if email exists
    static function hashtagExists(PDO $db, $hashtag) {
      $stmt = $db->prepare('SELECT * FROM hashtags WHERE name = ?');
      $stmt->execute(array($hashtag));
      return $stmt->fetch();
    }

    static function addHashtag(PDO $db, $hashtag){
      $stmt = $db->prepare('INSERT INTO hashtags (name) VALUES(?)');
      return $stmt->execute(array($hashtag));
    }
  }




?>