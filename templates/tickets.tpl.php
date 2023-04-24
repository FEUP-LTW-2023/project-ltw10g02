<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/classes/ticket.php')
?>

<?php 
function drawTickets(PDO $db, $tickets){ 
?>

<table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tickets as $ticket): ?>
        <tr>
          <td><?= $ticket->getId() ?></td>
          <td><?= $ticket->getSubject() ?></td>
          <td><?= $ticket->getDescription() ?></td>
          <td><?= $ticket->getStatus() ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

<?php 
}
?>

<?php function drawTicketsUser(PDO $db, $tickets){ ?>

  <section class = "user_tickets">
        <h1>My Tickets</h1>

        <?php drawTickets($db, $tickets) ?>

        <a href="../pages/create_ticket.php">Create a new ticket</a>

    </section>
<?php } ?>


<?php function drawTicketForm(Session $session, $departaments){ ?>
  <section id="ticketForm">
    <h1>Create a new ticket</h1>
    <form>
      <label>Department:
        <select name="department" required>
          <option value="">&mdash;</option>
          <?php foreach ($departaments as $departament): ?>
            <option value= "<?=$departament->getName()?>" > <?= $departament->getName() ?></option>
          <?php endforeach ?>
        </select>
      </label>
      <label>Subject:
        <input type="text" name="subject" placeholder="Subject" required>
      </label>
      <label>Description:
        <textarea name="description"></textarea>
      </label>
      <input type="hidden" name="user_id" value = <?=$session->getId()?>>
      <button formaction="/../actions/action_create_ticket.php" formmethod="post">Create ticket</button>
    </form>
  </section>
<?php } ?>