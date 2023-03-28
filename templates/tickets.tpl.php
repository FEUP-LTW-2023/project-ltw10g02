<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/classes/ticket.php')
?>

<?php 
function drawTickets($tickets, $db){ 
?>

<table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Subject</th>
        <th>Department</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($tickets as $ticket): ?>
        <?php
          $department = Department::getById($db, (int)$ticket->getDepartmentId());
          $departmentName = $department ? $department->getName() : '';
        ?>
        <tr>
          <td><?= $ticket->getId() ?></td>
          <td><?= $ticket->getSubject() ?></td>
          <td><?= $departmentName ?></td>
          <td><?= $ticket->getStatus() ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

<?php 
}
?>