
<?php
    require_once(__DIR__ . '/../templates/tickets.tpl.php');

?>


<?php function drawInfosProfile(Session $session, User $user, $tickets): void { ?>
    <section class = "user_info">
        <h1>Profile Page</h1>
        <?php if (!empty($tickets)): ?>
            <article id = "user_tickets">
                <h2>Last Tickets</h2>
                <?php drawTickets($tickets, 'profile_tickets') ?>
                <button onclick="redirectToPage('../pages/my_tickets.php')">Show all tickets</button>
            </article>
        <?php endif; ?>

        <?php drawBasicInfosProfile($session, $user) ?>
    </section>
<?php } ?>
 
<?php function drawBasicInfosProfile(Session $session, User $user): void {?>
    <article class ="user_basic_infos">
            <h2>My infos</h2>

                <span id= "name"> 
                    <p>
                        Name: 
                        <?= htmlentities($user->getName())?>
                        <img id="edit_name_img" onclick ="redirectToPage('/../pages/edit_name.php')" src="../images/icons/8666681_edit_icon.svg" alt="Edit name icon" />
                    </p>
                </span>

                <span id= "username">
                    <p>
                        Username: 
                        <?= htmlentities($user->getUsername())?>
                        <img id="edit_username_img" onclick ="redirectToPage('/../pages/edit_username.php')" src="../images/icons/8666681_edit_icon.svg" alt="Edit username icon" />
                    </p>
                </span>

                <span id= "email">
                    <p>
                        Email: 
                        <?= htmlentities($user->getEmail())?>
                        <img id="edit_email_img" onclick ="redirectToPage('/../pages/edit_email.php')" src="../images/icons/8666681_edit_icon.svg" alt="Edit email icon" />
                    </p>
                </span>

                <span id= "category">
                    <p>
                        Category: 
                        <?= $user->getCategory()?>
                        <!-- nenhum usuario pode mudar sua propria categoria
                        os admin podem mudar a categoria de outros usuarios
                        criar uma pagina "clients", que lista os clientes, e o admin pode alterar a categoria
                        criar uma pagina "AGENTS", que lista os agents, e o admin pode alterar a categoria e o departamento -->

                        <!-- <?php if ($session->getCategory() === "admin"): ?>
                        <img id="edit_category_img" onclick ="redirectToPage('/../pages/edit_category.php')" src="../images/icons/8666681_edit_icon.svg" alt="Edit category icon" />
                        <?php endif; ?> -->
                        </p>
                </span>

                <span id= "pass">
                    <p>
                        Password 
                        <img id="edit_pass_img" onclick ="redirectToPage('/../pages/edit_pass.php')" src="../images/icons/8666681_edit_icon.svg" alt="Edit pass icon" />
                    </p>
                </span>
            
        </article>
<?php } ?>

<?php function drawEditNameForm(Session $session, User $user): void {?>
    <section class = "edit_name">
        <h1>Edit Name</h1>

        <article class="user_basic_infos">
        
        <span id="name">
        <form action="/../actions/edit_profile/edit_name.php" method="post">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?php echo htmlentities($user->getName()) ?>">
            <input type="submit" value="Save changes">
        </form>
        </span>

        <span id= "username">
            <p>Username: <?= htmlentities($user->getUsername())?></p>
        </span>

        <span id= "email">
            <p>Email: <?= htmlentities($user->getEmail())?></p>
        </span>

        <span id= "category">
            <p>Category: <?= $user->getCategory()?></p>
        </span>

        <span id= "pass">
            <p>Password</p>
        </span>

        </article>      
    </section>
<?php } ?>

<?php function drawEditUsernameForm(Session $session, User $user): void {?>
    <section class = "edit_username">
        <h1>Edit Username</h1>

        <article class="user_basic_infos">
        
        <span id= "name">
            <p>Name: <?= htmlentities($user->getName())?></p>
        </span>

        <span id="username">
        <?php if ($session->getMessages()[0]['type'] === 'error'): ?>
            <div class="error">
                <p><?= $session->getMessages()[0]['text'] ?></p>
            </div>
        <?php endif; ?>
        <form action="/../actions/edit_profile/edit_username.php" method="post">
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" value="<?php echo htmlentities($user->getUsername()) ?>">
            <input type="submit" value="Save changes">
        </form>
        </span>

        <span id= "email">
            <p>Email: <?= htmlentities($user->getEmail())?></p>
        </span>

        <span id= "category">
            <p>Category: <?= htmlentities($user->getCategory())?></p>
        </span>

        <span id= "pass">
            <p>Password</p>
        </span>

        </article>      
    </section>
<?php } ?>

<?php function drawEditEmailForm(Session $session, User $user): void {?>
    <section class = "edit_email">
        <h1>Edit Email</h1>

        <article class="user_basic_infos">
        
        <span id= "name">
            <p>Name: <?= htmlentities($user->getName())?></p>
        </span>

        <span id= "username">
            <p>Username: <?= htmlentities($user->getUsername())?></p>
        </span>

        <span id="email">
        <?php if ($session->getMessages()[0]['type'] === 'error'): ?>
            <span class="error">
                <p><?= $session->getMessages()[0]['text'] ?></p>
            </span>
        <?php endif; ?>
        <form action="/../actions/edit_profile/edit_email.php" method="post">
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlentities($user->getEmail()) ?>">
            <input type="submit" value="Save changes">
        </form>
        </span>

        <span id= "category">
            <p>Category: <?= htmlentities($user->getCategory())?></p>
        </span>

        <span id= "pass">
            <p>Password</p>
        </span>

        </article>      
    </section>
<?php } ?>

<!-- falta aplicar -->
<?php function drawEditCategoryForm(Session $session, User $user): void {?>
    <section class = "edit_category">
        <h1>Edit Category</h1>

        <article class="user_basic_infos">
        
        <span id= "name">
            <p>Name: <?= htmlentities($user->getName())?></p>
        </span>

        <span id= "username">
            <p>Username: <?= htmlentities($user->getUsername())?></p>
        </span>

        <span id= "email">
            <p>Email: <?= htmlentities($user->getEmail())?></p>
        </span>
        
        <span id="category">
        <form action="/../actions/edit_profile/edit_category.php" method="post">
            <label for="category">Category: </label>
            <select id="category" name="category">
                <option value="client" <?php if ($user->getCategory() === 'client') echo 'selected'; ?>>Client</option>
                <option value="agent" <?php if ($user->getCategory() === 'agent') echo 'selected'; ?>>Agent</option>
                <option value="admin" <?php if ($user->getCategory() === 'admin') echo 'selected'; ?>>Admin</option>
            </select>
            <input type="submit" value="Save changes">
        </form>
        </span>

        <span id= "pass">
            <p>Password</p>
        </span>

        </article>      
    </section>
<?php } ?>

<?php function drawEditPassForm(Session $session, User $user): void {?>
    <section class = "edit_pass">
        <h1>Edit Password</h1>

        <article class="user_basic_infos">
        
        <span id="name">
            <p>Name: <?= htmlentities($user->getName())?></p>
        </span>

        <span id= "username">
            <p>Username: <?= htmlentities($user->getUsername())?></p>
        </span>

        <span id= "email">
            <p>Email: <?= htmlentities($user->getEmail())?></p>
        </span>

        <span id= "category">
            <p>Category: <?= $user->getCategory()?></p>
        </span>

        <span id= "pass">
        <form action="/../actions/edit_profile/edit_pass.php" method="post">
            <label for="old_pass">Old Password: </label>
            <p><input type="password" id="old_pass" name="old_pass"></p>
            <label for="new_pass">New Password: </label>
            <p><input type="password" id="new_pass" name="new_pass"></p>
            <label for="confirm_new_pass">Confirm New Password: </label>
            <p><input type="password" id="confirm_new_pass" name="confirm_new_pass"></p>
            <input type="submit" value="Save changes">

            <?php if ($session->getMessages()[0]['type'] === 'error'): ?>
                <div class="error">
                    <p><?= $session->getMessages()[0]['text'] ?></p>
                </div>
            <?php endif; ?>
        </form>
        </span>

        </article>      
    </section>
<?php } ?>
