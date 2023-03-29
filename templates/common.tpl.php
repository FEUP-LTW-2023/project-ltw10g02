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
  </head>
  <body>
    <header>
        <h1>My Tickets</header>

        <div id="signup">
          <?php if($session->isLoggedIn()): ?>
            <a href="../actions/action_logout.php">Logout</a>
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
      <label>
        Username/Email <input type="text" name="login">
      </label>
      <label>
        Password <input type="password" name="password">
      </label>
      <button formaction= '/../actions/action_login.php' formmethod="post">Login</button>
    </form>
  </section>
<?php } ?>

<?php function drawRegisterForm(){ ?>
    <section id="register">
      <h1>Register</h1>
      <form>
        <label>
          Name <input type="text" name="name" pattern="[A-Za-z ]+" title = "Only letters" required>
        </label>
        <label>
          Username <input type="text" name="username" required>
        </label>
        <label>
          Password <input type="password" name="password" required>
        </label>
        <label>
          Email <input type="email" name="email" required>
        </label>
        <button formaction= '/../actions/action_register.php' formmethod="post">Register</button>
      </form>
    </section>
<?php } ?>
