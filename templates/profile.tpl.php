
<?php
    require_once(__DIR__ . '/../templates/tickets.tpl.php');

?>


<?php function drawInfosProfile(User $user, $tickets): void { ?>
    <section class = "user_info">
        <h1>Profile Page</h1>

        <article class = "user_tickets">
            <h2>Last Tickets</h2>
            <?php drawTickets($tickets) ?>
            <button onclick="redirectToPage('../pages/my_tickets.php')">Show all tickets</button>
        </article>

        <article class ="user_basic_infos">
            <h2>My infos</h2>
            <p>Name : <?= $user->getName()?></p>
            <p>Username : <?= $user->getUsername()?></p>
            <p>Email : <?= $user->getEmail()?></p>
            <p>Category : <?= $user->getCategory()?></p>
            <button onclick="redirectToPage('/../pages/edit_profile.php')">Edit your profile</button>
        </article>
    </section>
<?php } ?>

<?php function drawEditProfileForm(User $user): void { ?>
    <section class = "edit_profile">
        <h1>Edit your profile page</h1>

        <article class ="user_basic_infos">
            <h2>Edit my info</h2>

            <form action="/../actions/action_update_profile.php" method="POST">
            <div>    
                <label for="name">Name: </label>
                    <input type="text" id="name" name="name" value="<?php echo $user->getName() ?>">
            </div>
            <div>
                <label for="username">Username: </label>
                    <input type="text" id="username" name="username" value="<?php echo $user->getUsername() ?>">
            </div>
            <div>
                <label for="email">E-mail: </label>
                    <input type="email" id="email" name="email" value="<?php echo $user->getEmail() ?>">
            </div>
            <div>            
                <label for="pass">New password:</label>
                    <input type="password" id="pass" name="pass">
            </div>
            <div>        
                <label for="pass">Confirm new password:</label>
                    <input type="password" id="pass" name="pass">  
            </div>
            <div>        
                <input type="submit" value="Save changes">
            </div>
            </form>

        </article>
    </section>
<?php } ?>
