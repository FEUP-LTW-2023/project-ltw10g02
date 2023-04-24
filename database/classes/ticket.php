<?php
declare(strict_types=1);

class Ticket {
  private $id;
  private $subject;
  private $description;
  private $status;
  private $priority;
  private $department_id;
  private $client_id;
  private $agent_id;
  private $faq_id;
  private $created_at;
  private $updated_at;

  public function __construct($id, $subject, $description, $status, $priority, $department_id, $client_id, $agent_id, $faq_id, $created_at, $updated_at) {
    $this->id = $id;
    $this->subject = $subject;
    $this->description = $description;
    $this->status = $status;
    $this->priority = $priority;
    $this->department_id = $department_id;
    $this->client_id = $client_id;
    $this->agent_id = $agent_id;
    $this->faq_id = $faq_id;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }

  public function getId(): int {
    return intval($this->id);
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

  public function getPriority(): string {
    return $this->priority;
  }

  public function getDepartmentId(): int {
    return intval($this->department_id);
  }
  
  public function getClientId(): int {
    return $this->client_id;
  }

  public function getAgentId(): int {
    return $this->agent_id;
  }

  public function getFaqId(): int {
    return $this->faq_id;
  }

  public function getCreatedAt(): string {
    return $this->created_at;
  }

  public function getUpdatedAt(): string {
    return $this->updated_at;
  }

  public static function addTicket(PDO $db, Session $session, $subject, $description, $client_id): void{
    try{
      $stmt = $db->prepare("INSERT INTO tickets (subject, description, client_id) VALUES (?, ?, ?)");
      $stmt->execute(array($subject, $description, $client_id));
      $session->addMessage('success', 'Ticket created successfully');
    } catch (PDOException $e) {
      $session->addMessage('error', $e->getMessage());
    }
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
            $ticket['department_id'],
            $ticket['client_id'],
            $ticket['agent_id'],
            $ticket['faq_id'],
            $ticket['created_at'],
            $ticket['updated_at']
        );
        $tickets[] = $ticket;
    }
    return $tickets;
  }

  public static function getAll(PDO $db): array {

    $tickets = array();
    $rows = $db->query('SELECT * FROM tickets');
    foreach ($rows as $row) {
      $ticket = new Ticket($row['id'], $row['subject'], $row['description'], $row['status'], $row['priority'], $row['department_id'], $row['client_id'], $row['agent_id'], $row['faq_id'], $row['created_at'], $row['updated_at']);
      $tickets[] = $ticket;
    }
    return $tickets;
  }
}

