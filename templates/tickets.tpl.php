<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/classes/ticket.php')
?>

<?php 
function drawTickets($tickets){ 
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
          <td><a href="../pages/ticket.php?id=<?=$ticket->getId()?>"><?= $ticket->getSubject()?></a></td>
          <td><?= $ticket->getDescription() ?></td>
          <td><?= $ticket->getStatus() ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

<?php 
}
?>

<?php 
function drawTicket(Ticket $ticket, $comments){ 
?>
  <section class = "ticketAndComments">
    <h1><?=$ticket->getSubject()?></h1>
    <article class = "ticket">
      <p><?=$ticket->getDescription()?></p>
    </article class>

    <article class = "comments">
      <h2>Comments</h2>
      <?php foreach ($comments as $comment): ?>
        <p><?=$comment->getBody()?></p>
      <?php endforeach ?>
    </article>
  </section>  


<?php 
}
?>

<?php function drawTicketsUser($tickets){ ?>

  <section class = "user_tickets">
        <h1>My Tickets</h1>

        <?php drawTickets($tickets) ?>

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