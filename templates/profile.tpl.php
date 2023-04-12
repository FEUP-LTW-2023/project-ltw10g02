
<?php
    require_once(__DIR__ . '/../templates/tickets.tpl.php');

?>


<?php function drawInfosProfile(PDO $db, User $user, $tickets): void { ?>
    <section class = "user_info">
        <h1>Profile Page</h1>

        <article class = "user_tickets">
            <h2>Last Tickets</h2>
            <?php drawTickets($db, $tickets) ?>
            <a href="../pages/tickets.php">Show all tickets</a>
        </article>

        <article class ="user_basic_infos">
            <h2>My infos</h2>
            <p>Name : <?= $user->getName()?></p>
            <p>Username : <?= $user->getUsername()?></p>
            <p>Email : <?= $user->getEmail()?></p>
            <p>Category : <?= $user->getCategory()?></p>
            <button formaction="/../actions/action_update_profile.php" formmethod="post">Edit your profile</button>
        </article>
    </section>
<?php } ?>
