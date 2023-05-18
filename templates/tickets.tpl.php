<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/classes/ticket.php')
?>

<?php 
function drawTickets($tickets, $div_id){ 
?>
  <div id = <?=$div_id?>>
    <?php foreach ($tickets as $ticket): ?>
      <article class = "ticketResume">
        <header>
          <h2><a href="../pages/ticket.php?id=<?=$ticket->getId()?>"><?=htmlentities($ticket->getSubject())?></a></h2>
          <p><?=htmlentities($ticket->getStatus())?></p>
        </header>
        <p><?=$ticket->getCreatedAt()?></p>
        <p><?=htmlentities($ticket->getDescription())?></p>
      </article>
    <?php endforeach ?>
    </div> 
<?php 
}
?>

<?php function drawTicketHistory($db, $ticket_id){
  $ticketHistory = TicketHistory::getHistoryByTicketId($db, $ticket_id, $numberHistory = -1);
?>
  <aside class="ticketHistory">
    <h2>Ticket History</h2>
    <ul>
    <?php foreach ($ticketHistory as $history): ?>
      <li class="ticketHistory-item">
        <div class="ticketHistory-box">
          <div>
            <?php  
              $department = Department::getDepartmentById($db, $history->getDepartmentId());
            ?>
              <p>Department: <?=htmlentities($department->getName())?></p>
            <p>Status: <?=htmlentities($history->getStatus())?></p>
              <!-- create a link to show faq -->
            <?php
              $faqId = $history->getFaqId();
              if ($faqId === null):?>
            <p>FAQ: none associated</p>
            <?php 
              else: 
                $faq= FAQ::getById($db, $faqId);
                if ($faq !== null):?>
                  <p>FAQ: <a href="../pages/faqs.php"><?= htmlentities($faq->getQuestion()) ?></a></p>
                <?php 
                endif;
              endif; 
            ?>

          </div>
          
          <div>
            <p>Modification: <?=$history->getUpdatedAt()?></p>
            <?php
              $agent = User::getUserById($db, $history->getAgentId());
            ?>
              <p>Agent: <?=$agent === null ? 'Not defined' : htmlentities($agent->getName())?></p>
            <p>Priority: <?=$history->getPriority() === null ? 'Not defined' : htmlentities($history->getPriority())?></p>
            
          </div>
        </div>
      </li>
    <?php endforeach ?>
    </ul>
  </aside>
<?php } ?>

<?php  function drawTicket(Ticket $ticket, Session $session, array $comments, User $user_ticket, $agent_ticket, $department, $hashtags, array $users_comments){ ?>
  <section id = "ticketAndComments">  

    <article class = "ticket">
      <h1><?=htmlentities($ticket->getSubject())?></h1>
      <p><?=htmlentities($user_ticket->getName())?></p>
      <p><?=$ticket->getCreatedAt()?></p>

      <span id = "edit_status">
        <p><?=htmlentities($ticket->getStatus())?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_status_img" onclick ="editField('<?= $ticket->getId() ?>', 'status')" src="../images/icons/8666681_edit_icon.svg" alt="Edit status icon">
        <?php endif; ?>
      </span>

      <span id = "edit_department">
        <p><?=$department === null ? 'Not defined' : htmlentities($department->getName())?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_department_img" onclick ="editField('<?= $ticket->getId() ?>', 'department')" src="../images/icons/8666681_edit_icon.svg" alt="Edit department icon">
        <?php endif; ?>
      </span>

      <span id = "edit_agent">
        <p><?=$agent_ticket === null ? 'Not defined' : htmlentities($agent_ticket->getName())?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_agent_img" onclick ="editField('<?= $ticket->getId() ?>', 'agent')" src="../images/icons/8666681_edit_icon.svg" alt="Edit agent ticket icon">
        <?php endif; ?>
      </span> 

      <span id = "edit_priority">
        <p><?=$ticket->getPriority() === null ? 'Not defined' : htmlentities($ticket->getPriority())?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_priority_img" onclick ="editField('<?= $ticket->getId() ?>', 'priority')" src="../images/icons/8666681_edit_icon.svg" alt="Edit priority ticket icon">
        <?php endif; ?>
      </span> 

      <p><?=htmlentities($ticket->getDescription())?></p>

      <div id = "edit_hashtags">
        <p><?=empty($hashtags) ? 'Hashtags: Not defined' : 'Hashtags: ' . htmlentities($hashtags) ?></p>
        <?php if ($session->getCategory() !== "client"): ?>
          <img id = "edit_hashtags_img" onclick ="editHashtag('<?= $ticket->getId() ?>')" src="../images/icons/8666681_edit_icon.svg" alt="Edit hashtags icon">
        <?php endif; ?>
        </div>
      
      <?php if ($session->getCategory() === "client"): ?>
          <button onclick = "editTicketUser('<?= $ticket->getId() ?>')">Edit ticket</button>
      <?php endif; ?>
      
    </article>

    <h2>Comments</h2>
    <?php $length = min(count($comments), count($users_comments)) ?>
    <?php for ($i = 0; $i < $length; $i++): ?>
      <article class = "comments">
        <p><?=htmlentities($users_comments[$i]->getName())?></p>
        <p><?=$comments[$i]->getUpdatedAt()?></p>
        <p><?=htmlentities($comments[$i]->getBody())?></p>
      </article>
    <?php endfor ?>
    
    <?php drawCommentForm($ticket->getId()) ?>
    
  </section>  

<?php } ?>

<?php function drawSearchFormInput($form_id, $input_id, $departments){ ?>
  <span class = "search_menu">
    <form id = <?=$form_id?>>
    <label for="department">Department:</label>
    <select name="department" class="department_form_search">
      <option value="my_departments">My departments</option>
      <?php foreach ($departments as $department) { ?>
        <option value= <?= $department->getId()?>><?= htmlentities($department->getName())?></option>
      <?php } ?>
    </select>
      
    <label for="status">Status:</label>
    <select name="status" class="status_form_search">
      <option value="All">All</option>
      <option value="Open">Open</option>
      <option value="Assigned">Assigned</option>
      <option value="Closed">Closed</option>
    </select>

    <label for="priority">Priority:</label>
    <select name="priority" class="priority_form_search">
      <option value="All">All</option>
      <option value="Low">Low</option>
      <option value="Medium">Medium</option>
      <option value="High">High</option>
    </select>
    </form>
    <input id= <?=$input_id?> type="text" placeholder="Search your ticket">
  </span>
<?php } ?>

<?php function drawTicketsUser(Session $session, $tickets, $departments){ ?>

  <section class = "my_tickets">
      <h1>My Tickets</h1>

      <?php drawSearchFormInput('form_my_tickets', 'search_tickets_client', $departments) ?>
      <?php drawTickets($tickets, 'my_tickets') ?>

      <a href="../pages/create_ticket.php">Create a new ticket</a>
  </section>
<?php } ?>

<?php function drawTicketsAgent(Session $session, $tickets_agent, $tickets_departments, $departments, $departments_agent_tickets){ ?>

<section class = "my_tickets">
    <h1>My Tickets</h1>

    <?php drawSearchFormInput('form_my_tickets', 'search_tickets_agent', $departments_agent_tickets) ?>
    <?php drawTickets($tickets_agent, 'my_tickets') ?>
</section>

<section id = "department_tickets_section">
    <h1>Tickets Department</h1>
    <!-- <input id="search_tickets" type="text" placeholder="Search your ticket"> -->

    <?php drawSearchFormInput('form_department_tickets', 'search_deparment_tickets', $departments) ?>
    <?php drawTickets($tickets_departments, 'department_tickets') ?>
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
            <option value="<?=$departament->getId()?>"> <?= htmlentities($departament->getName()) ?></option>
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