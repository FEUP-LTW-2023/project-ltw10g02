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
    $this->department_id = $department_id;
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

  public function getPriority(){
    return $this->priority;
  }

  public function getClientId(){
    return $this->client_id;
  }

  public function getDepartmentId(): ?int{
    return intval($this->department_id);
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

  public function setSubject($subject): void {
      $this->subject = $subject;
  }

  public function setDescription($description): void {
      $this->description = $description;
  }

  public function setStatus($status): void {
      $this->status = $status;
  }

  public function setPriority($priority): void {
      $this->priority = $priority;
  }

  public function setClientId($client_id): void {
      $this->client_id = $client_id;
  }

  public function setDepartmentId($department_id): void {
      $this->department_id = $department_id;
  }

  public function setAgentId($agent_id): void {
      $this->agent_id = $agent_id;
  }

  public function setFaqId($faq_id): void {
      $this->faq_id = $faq_id;
  }

  public function setProductId($product_id): void {
      $this->product_id = $product_id;
  }


  function updateTicket(PDO $db) {
    $stmt = $db->prepare('
        UPDATE Tickets SET subject = ?, description = ?, status = ?, priority = ?, department_id = ?, agent_id = ?, faq_id = ?, product_id = ?
        WHERE id = ?
      ');

    return $stmt->execute(array($this->subject, $this->description, $this->status, $this->priority, $this->department_id, $this->agent_id, $this->faq_id, $this->product_id, $this->id));
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

  public static function searchTickets(PDO $db, $id, $category = '', $user_department = '', $search = '', $department = '', $status = '', $priority = ''): array {
    $tickets = array();

    if($department === "my_departments" || $department  === "") {
      $user_department_ids = array();

      foreach ($user_department as $department) {
        if($category === "")
          $user_department_ids[] = $department->getDepartmentId();
        else
          $user_department_ids[] = $department->getId();
      }
      
      $placeholders = implode(',', array_fill(0, count($user_department_ids), '?'));
      $sql = "SELECT * FROM tickets WHERE department_id IN ($placeholders)";
      $params = $user_department_ids;
    }
    else{
      $params = array();
      $sql = "SELECT * FROM tickets WHERE department_id = ?";
      $params[] = $department;
    }
    if($category === 'client'){
      $sql .= ' AND client_id = ?';
      $params[] = $id;  
    }
    else if($category === 'agent'){
      $sql .= ' AND agent_id = ?'; 
      $params[] = $id;
    }

  
    if (!empty($search)) {
        $sql .= " AND subject LIKE ?";
        $params[] = $search . "%";
    }
    
    if (!empty($status) && $status !== "All") {
        $sql .= " AND status = ?";
        $params[] = $status;
    }

    if (!empty($priority) && $priority !== "All") {
      $sql .= " AND priority = ?";
      $params[] = $priority;
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    
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

  public static function getTicketsByDepartments(PDO $db, $user_department): array {
    $tickets = array();

    $user_department_ids = array();
    foreach ($user_department as $department) {
        $user_department_ids[] = $department->getDepartmentId();
    }

    $placeholders = implode(',', array_fill(0, count($user_department_ids), '?'));
    $sql = "SELECT * FROM tickets WHERE department_id IN ($placeholders)";

    $stmt = $db->prepare($sql);
    $stmt->execute($user_department_ids);
    
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
}

