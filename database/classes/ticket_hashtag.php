<?php 
class TicketHashtag implements JsonSerializable {
    private $ticket_id;
    private $hashtag_id;
    
    public function __construct($ticket_id, $hashtag_id) {
      $this->ticket_id = $ticket_id;
      $this->hashtag_id = $hashtag_id;
    }

    public function jsonSerialize() {
        return [
          'ticket_id' => $this->ticket_id,
          'hashtag_id' => $this->hashtag_id,
        ];
    }
    
    public function getTicketId() {
      return $this->ticket_id;
    }
    
    public function getHashtagId() {
      return $this->hashtag_id;
    }

    static function getByTicketId(PDO $db, $ticket_id): ?array {
        $ticketHashtags = array();
        $stmt = $db->prepare('SELECT *
                            FROM ticket_hashtags
                            WHERE ticket_id = ?');
    
        $stmt->execute(array($ticket_id)); 

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
          $ticketHashtag = new TicketHashtag($row['ticket_id'], $row['hashtag_id']);
          $ticketHashtags[] = $ticketHashtag;
        }

        return $ticketHashtags;
    }

    static function removeHashtagFromTicket(PDO $db, $ticket_id, $hashtag_id) {
      $stmt = $db->prepare('DELETE
                          FROM ticket_hashtags
                          WHERE ticket_id = ? AND hashtag_id = ?');
  
      return $stmt->execute(array($ticket_id, $hashtag_id)); 
  }
  
}
?>
