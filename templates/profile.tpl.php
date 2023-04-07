
<?php function drawInfosProfile(PDO $db, User $user, $tickets): void { ?>
    <section class = "user_info">
        <h1>Profile Page</h1>
        <article class = "user_tickets">
            <h2>Last Tickets</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                        <td><?= $ticket->getId() ?></td>
                        <td><?= $ticket->getSubject() ?></td>
                        <td><?= $ticket->getStatus() ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <button formaction="/../pages/tickets.php" formmethod="post">Show all tickets</button>
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
