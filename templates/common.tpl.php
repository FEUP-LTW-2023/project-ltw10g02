<?php 
  declare(strict_types = 1); 
  function drawHeader(Session $session): void { ?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>My Tickets</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/layout.css">
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
                <li><a href="#">Profile</a></li>
                <li><a href="#">My tickets</a></li>
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
      Clothing Store Tickets &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm(){ ?>
  <section id="login">
    <h1>Login</h1>
    <form>
      <input type="text" name="login" placeholder="Username/Email">
      <input type="password" name="password" placeholder="Password">
      <button formaction= '/../actions/action_login.php' formmethod="post">Login</button>
    </form>
  </section>
<?php } ?> 

<?php function drawRegisterForm(Session $session){ ?>
  <section id="register">
    <h1>Create a new account</h1>
    <form>
      <input type="text" name="name" pattern="[A-Za-zÀ-ú ]+" title="Only letters" value="<?= $session->getMessages()[1]['text'] ?>" placeholder="Name" required>
      <input type="text" name="username" value="<?= $session->getMessages()[2]['text'] ?>" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="email" name="email" value="<?= $session->getMessages()[3]['text'] ?>" placeholder="Email" required>
      <button formaction="/../actions/action_register.php" formmethod="post">Register</button>
    </form>
    <?php if ($session->getMessages()[0]['type'] === 'error'): ?>
      <span class="error">
        <p><?= $session->getMessages()[0]['text'] ?></p>
      </span>
    <?php endif; ?>
  </section>
<?php } ?>
