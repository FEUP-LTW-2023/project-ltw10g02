<?php 
  declare(strict_types = 1); 
  function drawHeader(Session $session, $currentPage=''): void { ?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>My Tickets</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/ticket.css">
    <link rel="stylesheet" href="../css/my_ticket.css">
    <link rel="stylesheet" href="../css/profile.css">
    <?php if ($currentPage==="ticket.php") : ?>
      <link rel="stylesheet" href="../css/ticket_history.css">
    <?php endif; ?>
    <script src="../javascript/editTicket.js" defer></script>
    <script src="../javascript/searchTicket.js" defer></script>
    <script src="../javascript/addComment.js" defer></script>
    <script src="../javascript/util.js" defer></script>
  </head>
  <body>
    <header>
        <h1><a href="../index.php">My Tickets</a></h1>

        <div id="signup">
          <?php if($session->isLoggedIn()): ?>
            <nav class="menu-user">
              <input type="checkbox" class="menu-toggle-user" id="menu-toggle-user">
              <label for="menu-toggle-user">
                <span id = "icon-menu-user"></span>
              </label>
              <ul class="menu-user-itens">
                <li><a href="../pages/profile.php">Profile</a></li>
                <li><a href="../pages/my_tickets.php">My tickets</a></li>
                <?php if($session->getCategory() === 'admin'): ?>
                  <li><a href="../pages/admin_area.php">Admin area</a></li>
                <?php endif; ?>
                <li><a href="../actions/action_logout.php">Logout</a></li>
              </ul>
            </nav>
            <!-- <a href="../pages/profile.php"><span id = "icon-menu-user"></span></a>
            <a href="../actions/action_logout.php">Logout</a> -->
          <?php else: ?>
            <a href="../pages/register.php">Register</a>
            <a href="../pages/login.php">Login</a>
          <?php endif; ?>
        </div>
    </header>
    <main>
<?php } ?>

<?php function drawFooter(): void { ?>
    </main>

    <footer>
      FEUP Style &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm($session){ ?>
  <section id="login">
    <h1>Login</h1>
    <form>
      <input type="text" name="login" placeholder="Username/Email">
      <input type="password" name="password" placeholder="Password">
      <button formaction= '../actions/action_login.php' formmethod="post">Login</button>
    </form>

      <div class="error">
        <p><?= $session->getMessages()[0]['text'] ?></p>
      </div>
  </section>
<?php } ?> 

<?php function drawRegisterForm(Session $session){ ?>
  <section id="register">
    <h1>Create a new account</h1>
    <form>
      <input type="text" name="name" pattern="[A-Za-zÀ-ú ]+" title="Only letters" value="<?= $session->getFormValues()['name'] ?>" placeholder="Name" required>
      <input type="text" name="username" value="<?= $session->getFormValues()['username'] ?>" placeholder="Username" required>
      <input type="email" name="email" value="<?= $session->getFormValues()['email'] ?>" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="password_repeated" placeholder="Repeat password" required>
      <button formaction="/../actions/action_register.php" formmethod="post">Register</button>
    </form>
    <?php if ($session->getMessages()[0]['type'] === 'error'): ?>
      <span class="error">
        <p><?= $session->getMessages()[0]['text'] ?></p>
      </span>
    <?php endif; ?>
  </section>
<?php } ?>
