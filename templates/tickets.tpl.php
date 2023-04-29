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

<?php  function drawTicket(Ticket $ticket, array $comments, User $user_ticket, array $users_comments){ ?>
  <section id = "ticketAndComments">

    <article class = "ticket">
      <h1><?=$ticket->getSubject()?></h1>
      <p><?=$user_ticket->getName()?></p>
      <p><?=$ticket->getCreatedAt()?></p>
      <p><?=$ticket->getDescription()?></p>
    </article>

    <h2>Comments</h2>
    <?php $length = min(count($comments), count($users_comments)) ?>
    <?php for ($i = 0; $i < $length; $i++): ?>
      <article class = "comments">
        <p><?=$users_comments[$i]->getName()?></p>
        <p><?=$comments[$i]->getUpdatedAt()?></p>
        <p><?=$comments[$i]->getBody()?></p>
      </article>
    <?php endfor ?>
    
    <?php drawCommentForm($ticket->getId()) ?>
    

  </section>  

<?php } ?>

<?php function drawTicketsUser($tickets){ ?>

  <section class = "user_tickets">
      <h1>My Tickets</h1>
      <input id="search_tickets" type="text" placeholder="Search your ticket">

      <?php drawTickets($tickets) ?>

      <a href="../pages/create_ticket.php">Create a new ticket</a>
  </section>
<?php } ?>


<?php function drawTicketForm(Session $session, $departaments){ ?>
  <section id="ticketForm">
    <h1>Create a new ticket</h1>
    <form>
      <label>Department:
        <select name="department_id" required>
          <option value="">&mdash;</option>
          <?php foreach ($departaments as $departament): ?>
            <option value="<?=$departament->getId()?>"> <?= $departament->getName() ?></option>
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

<?php function drawCommentForm($ticket_id){ ?>
    <form id = "add_comment">
      <textarea name="comment" placeholder="Add a new comment"></textarea>
      <input type="hidden" name="ticket_id" value = <?=$ticket_id?>>
      <button onclick ="addComment()">Add comment</button>
    </form>
<?php } ?> 