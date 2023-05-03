<?php
declare(strict_types=1);

class TicketHistory implements JsonSerializable{
  private $id;
  private $ticket_id;
  private $subject;
  private $description;
  private $status;
  private $priority;
  private $department_id;
  private $agent_id;
  private $faq_id;
  private $updated_at;
 
  public function __construct($id, $ticket_id, $subject, $description, $status, $priority, $department_id, $agent_id, $faq_id, $updated_at){
    $this->id = $id;
    $this->ticket_id = $ticket_id;
    $this->subject = $subject;
    $this->description = $description;
    $this->status = $status;
    $this->priority = $priority;
    $this->department_id = $department_id;
    $this->agent_id = $agent_id;
    $this->faq_id = $faq_id;
    $this->updated_at = $updated_at;
  }

  public function jsonSerialize(){
    return array(
      'id' => $this->id,
      'ticket_id' => $this->ticket_id,
     'subject' => $this->subject,
      'description' => $this->description,
     'status' => $this->status,
      'priority' => $this->priority,
      'department_id' => $this->department_id,
      'agent_id' => $this->agent_id,
      'faq_id' => $this->faq_id,
      'updated_at' => $this->updated_at
    );
  }

  public function getId() {
    return intval($this->id);
  }
  public function getTicketId() {
    return intval($this->ticket_id);
  }
  public function getSubject() {
    return $this->subject;
  }
  public function getDescription() {
    return $this->description;
  }
  public function getStatus() {
    return $this->status;
  }
  public function getPriority() {
    return $this->priority;
  }
  public function getDepartmentId() {
    return intval($this->department_id);
  }
  public function getAgentId() {
    return intval($this->agent_id);
  }
  public function getFaqId() {
    return intval($this->faq_id);
  }
  public function getUpdatedAt() {
    return $this->updated_at;
  }

  public static function createTicketHistory(PDO $db, Session $session, $ticket_id, $subject, $description, $status, $priority, $department_id, $agent_id, $faq_id, $updated_at): void{
    try{
        $stmt=$db->prepare('INSERT INTO ticket_history (ticket_id, subject, description, status, priority, department_id, agent_id, faq_id, updated_at) VALUES (?,?,?,?,?,?,?,?,?)');
        $stmt->execute(array($ticket_id, $subject, $description, $status, $priority, $department_id, $agent_id, $faq_id, $updated_at));
        $session->addMessage('success', 'Added Ticket History');
    } catch (PDOException $e) {
        $session->addMessage('error', $e->getMessage());
    }
  }

  public static function getHistoryByTicketId(PDO $db, $ticket_id, $numberHistory = -1): array{
    $history = array();
    $query = 'SELECT * FROM ticket_history WHERE ticket_id = ? ORDER BY updated_at';
    if($numberHistory > 0){
      $query .= ' LIMIT '.$numberHistory;
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($ticket_id));
    foreach($stmt as $row){
        $row = new TicketHistory(
            $row['id'],
            $row['ticket_id'], 
            $row['subject'], 
            $row['description'], 
            $row['status'], 
            $row['priority'], 
            $row['department_id'], 
            $row['agent_id'], 
            $row['faq_id'], 
            $row['updated_at']
        );
        $history[] = $row;
    }
    return $history;
  }


}

