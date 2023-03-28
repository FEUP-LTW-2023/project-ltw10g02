<?php

require_once __DIR__ . '/database/database_connection.php';
require_once __DIR__ . '/database/classes/department.php';
require_once __DIR__ . '/database/classes/faq.php';
require_once __DIR__ . '/database/classes/ticket.php';
require_once __DIR__ . '/database/classes/user.php';

// Retrieve all tickets from the database
$db = getDatabaseConnection();
$tickets = Ticket::getAll($db);

// Display the tickets in an HTML table
?>
<html>
<head>
  <title>My Tickets</title>
</head>
<body>
  <h1>My Tickets</h1>
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
</body>
</html>

