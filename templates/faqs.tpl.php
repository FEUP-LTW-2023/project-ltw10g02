<?php 
  declare(strict_types = 1);
  require_once(__DIR__ . '/../database/classes/faq.php')
?>



<?php function drawFAQs(PDO $db, $session, $user, $faqs): void { 
  $messages = $session->getMessages();  
?>
  <section id="faqs">
    <h1>Frequently Asked Questions</h1>

    <ul>
      <?php foreach ($faqs as $faq): ?>
        <li class=faq>
          <div class="faq">
            <h2><?= $faq->getQuestion() ?></h2>
              <p><?=$faq->getAnswer()?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

    <!-- Display the messages -->
  <?php foreach ($messages as $message): ?>
    <div class="message <?= $message['type'] ?>">
      <?= $message['text'] ?>
    </div>
  <?php endforeach; ?>

    <?php if ($session->getCategory() !== "client"): ?>
      <form action="/../actions/action_create_faq.php" method="post">
        <label for="question">Question:</label>
        <input type="text" id="question" name="question" value="Question here" required>
        <label for="answer">Answer:</label>
        <p>
          <textarea id="answer" name="answer" required>Answer here</textarea>
        </p>
        <button type="submit" id="add_faq_button">Add FAQ</button>
      </form>
    <?php endif; ?>
  </section>
<?php } ?> 