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

  public function getId() {
    return $this->id;
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
    return $this->department_id;
  }

  public function getClientId() {
    return $this->client_id;
  }

  public function getAgentId() {
    return $this->agent_id;
  }

  public function getFaqId() {
    return $this->faq_id;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }

  public static function getAll($db) {

    $tickets = array();
    $rows = $db->query('SELECT * FROM tickets');
    foreach ($rows as $row) {
      $ticket = new Ticket($row['id'], $row['subject'], $row['description'], $row['status'], $row['priority'], $row['department_id'], $row['client_id'], $row['agent_id'], $row['faq_id'], $row['created_at'], $row['updated_at']);
      $tickets[] = $ticket;
    }
    return $tickets;
  }
}

