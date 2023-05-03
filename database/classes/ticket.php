<?php
declare(strict_types=1);

class Ticket implements JsonSerializable{
  private $id;
  private $subject;
  private $description;
  private $status;
  private $priority;
  private $client_id;
  private $department_id;
  private $agent_id;
  private $faq_id;
  private $product_id;
  private $created_at;

  
  public function __construct($id, $subject, $description, $status, $priority, $client_id, $department_id, $agent_id, $faq_id, $product_id, $created_at) {
    $this->id = $id;
    $this->subject = $subject;
    $this->description = $description;
    $this->status = $status;
    $this->priority = $priority;
    $this->client_id = $client_id;
    $this->department_id = $agent_id;
    $this->agent_id = $agent_id;
    $this->faq_id = $faq_id;
    $this->product_id = $product_id;
    $this->created_at = $created_at;
  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'subject' => $this->subject,
      'description' => $this->description,
      'status' => $this->status,
      'priority' => $this->priority,
      'client_id' => $this->client_id,
      'department_id' => $this->department_id,
      'agent_id' => $this->agent_id,
      'faq_id' => $this->faq_id,
      'product_id' => $this->product_id,
      'created_at' => $this->created_at
    ];
  }

  public function getId(): int {
    return $this->id;
  }

  public function getSubject(): string {
    return $this->subject;
  }

  public function getDescription(): string {
    return $this->description;
  }

  public function getStatus(): string {
    return $this->status;
  }

  public function getPriority(){
    return $this->priority;
  }

  public function getClientId(){
    return $this->client_id;
  }

  public function getDepartmentId(){
    return $this->department_id;
  }

  public function getAgentId(){
    return $this->agent_id;
  }

  public function getFaqId(): int {
    return $this->faq_id;
  }

  public function getCreatedAt(): string {
    return $this->created_at;
  }

  public static function addTicket(PDO $db, Session $session, $subject, $description, $client_id, $department_id): void{
    try{
      $stmt = $db->prepare("INSERT INTO tickets (subject, description, client_id, department_id) VALUES (?, ?, ?, ?)");
      $stmt->execute(array($subject, $description, $client_id, $department_id));
      $session->addMessage('success', 'Ticket created successfully');
    } catch (PDOException $e) {
      $session->addMessage('error', $e->getMessage());
    }
  }

  public static function getTicketById(PDO $db, $id): ?Ticket {
    $stmt = $db->prepare('SELECT * FROM tickets WHERE id = ?');
    $stmt->execute(array($id));

    if($ticket = $stmt->fetch()) {
        return new Ticket(
            $ticket['id'],
            $ticket['subject'],
            $ticket['description'],
            $ticket['status'],
            $ticket['priority'],
            $ticket['client_id'],
            $ticket['department_id'],
            $ticket['agent_id'],
            $ticket['faq_id'],
            $ticket['product_id'],
            $ticket['created_at']
        );
    } else return null;
  }
  

  public static function getTicketsByUser(PDO $db, $id, $numberTickets = -1): array {
    $tickets = array();
    $query = 'SELECT * FROM tickets WHERE client_id = ?';
    if ($numberTickets > 0) {
        $query .= ' LIMIT '.$numberTickets;
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($id));
    foreach ($stmt as $ticket) {
        $ticket = new Ticket(
            $ticket['id'],
            $ticket['subject'],
            $ticket['description'],
            $ticket['status'],
            $ticket['priority'],
            $ticket['client_id'],
            $ticket['department_id'],
            $ticket['agent_id'],
            $ticket['faq_id'],
            $ticket['product_id'],
            $ticket['created_at']
        );
        $tickets[] = $ticket;
    }
    return $tickets;
  }

  public static function getTicketsByAgent(PDO $db, $id, $numberTickets = -1): array {
    $tickets = array();
    $query = 'SELECT * FROM tickets WHERE agent_id = ?';
    if ($numberTickets > 0) {
        $query .= ' LIMIT '.$numberTickets;
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($id));
    foreach ($stmt as $ticket) {
        $ticket = new Ticket(
            $ticket['id'],
            $ticket['subject'],
            $ticket['description'],
            $ticket['status'],
            $ticket['priority'],
            $ticket['client_id'],
            $ticket['department_id'],
            $ticket['agent_id'],
            $ticket['faq_id'],
            $ticket['product_id'],
            $ticket['created_at']
        );
        $tickets[] = $ticket;
    }
    return $tickets;
  }

  public static function getTicketsByDepartment(PDO $db, $department_id): array {
    $tickets = array();

    $stmt = $db->prepare('SELECT * FROM tickets WHERE department_id = ?');
    $stmt->execute(array($department_id));
    foreach ($stmt as $ticket) {
        $ticket = new Ticket(
            $ticket['id'],
            $ticket['subject'],
            $ticket['description'],
            $ticket['status'],
            $ticket['priority'],
            $ticket['client_id'],
            $ticket['department_id'],
            $ticket['agent_id'],
            $ticket['faq_id'],
            $ticket['product_id'],
            $ticket['created_at']
        );
        $tickets[] = $ticket;
    }
    return $tickets;
  }

  public static function getAll(PDO $db): array {

    $tickets = array();
    $rows = $db->query('SELECT * FROM tickets');
    foreach ($rows as $row) {
      $ticket = new Ticket($row['id'], $row['subject'], $row['description'], $row['status'], $row['priority'], $row['client_id'], $row['department_id'], $row['agent_id'], $row['faq_id'], $row['product_id'], $row['created_at']);
      $tickets[] = $ticket;
    }
    return $tickets;
  }

  public static function searchTicketsUser(PDO $db, int $id, string $search): array {
    $tickets = array();

    $stmt = $db->prepare('SELECT * FROM tickets WHERE client_id = ? and subject LIKE ?');
    $stmt->execute(array($id, $search . '%'));
    
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $row) {
        $ticket = new Ticket($row['id'], $row['subject'], $row['description'], $row['status'], $row['priority'], $row['client_id'], $row['department_id'], $row['agent_id'], $row['faq_id'], $row['product_id'], $row['created_at']);
        $tickets[] = $ticket;
    }

    return $tickets;
  }
}

