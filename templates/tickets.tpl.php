<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/classes/ticket.php')
?>

<?php 
function drawTickets($tickets){ 
?>
  <div id = "ticketResumeSection">
    <?php foreach ($tickets as $ticket): ?>
      <article class = "ticketResume">
        <header>
          <h2><a href="../pages/ticket.php?id=<?=$ticket->getId()?>"><?=$ticket->getSubject()?></a></h2>
          <p><?=$ticket->getStatus()?></p>
        </header>
        <p><?=$ticket->getCreatedAt()?></p>
        <p><?=$ticket->getDescription()?></p>
      </article>
    <?php endforeach ?>
    </div> 
<?php 
}
?>

<?php  function drawTicket(Ticket $ticket, Session $session, array $comments, User $user_ticket, $agent_ticket, $department, $hashtags, array $users_comments){ ?>
  <section id = "ticketAndComments">  

    <article class = "ticket">
      <h1><?=$ticket->getSubject()?></h1>
      <p><?=$user_ticket->getName()?></p>
      <p><?=$ticket->getCreatedAt()?></p>

      <span id = "edit_status">
        <p><?=$ticket->getStatus()?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_status_img" onclick ="editField('<?= $ticket->getId() ?>', 'status')" src="../images/icons/8666681_edit_icon.svg" alt="Edit status icon">
        <?php endif; ?>
      </span>

      <span id = "edit_department">
        <p><?=$department === null ? 'Not defined' : $department->getName()?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_department_img" onclick ="editField('<?= $ticket->getId() ?>', 'department')" src="../images/icons/8666681_edit_icon.svg" alt="Edit department icon">
        <?php endif; ?>
      </span>

      <span id = "edit_agent">
        <p><?=$agent_ticket === null ? 'Not defined' : $agent_ticket->getName()?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_agent_img" onclick ="editField('<?= $ticket->getId() ?>', 'agent')" src="../images/icons/8666681_edit_icon.svg" alt="Edit agent ticket icon">
        <?php endif; ?>
      </span> 

      <span id = "edit_priority">
        <p><?=$ticket->getPriority() === null ? 'Not defined' : $ticket->getPriority()?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_priority_img" onclick ="editField('<?= $ticket->getId() ?>', 'priority')" src="../images/icons/8666681_edit_icon.svg" alt="Edit priority ticket icon">
        <?php endif; ?>
      </span> 

      <p><?=$ticket->getDescription()?></p>

      <span id = "edit_hashtags">
        <p><?=empty($hashtags) ? 'Not defined' : $hashtags ?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_hashtags_img" onclick ="editField('<?= $ticket->getId() ?>')" src="../images/icons/8666681_edit_icon.svg" alt="Edit hashtags icon">
        <?php endif; ?>
      </span>
      
      <?php if ($session->getCategory() === "client"): ?>
          <button onclick = "editTicketUser('<?= $ticket->getId() ?>')">Edit ticket</button>
      <?php endif; ?>
      
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

<?php function drawTicketsUser(Session $session, $tickets){ ?>

  <section id = "user_tickets">
      <h1>My Tickets</h1>
      <input id="search_tickets" type="text" placeholder="Search your ticket">

      <?php drawTickets($tickets) ?>

      <?php if ($session->getCategory() === "client"): ?>
        <a href="../pages/create_ticket.php">Create a new ticket</a>
      <?php endif; ?>
      
      <?php if ($session->getCategory() !== "client"): ?>
        <h1>Tickets Department</h1>
      <?php endif; ?>
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
      <textarea name="comment" placeholder="Add a new comment" required></textarea>
      <input type="hidden" name="ticket_id" value = <?=$ticket_id?>>
      <button onclick ="addComment()">Add comment</button>
    </form>
<?php } ?> 