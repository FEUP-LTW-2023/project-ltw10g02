<?php function addDepartment(Session $session) {?>
    <form id = "add_department">
        <input type="text" name="name_department" pattern="[A-Za-zÀ-ú ]+" value = "<?= $session->getFormValues()['name']?>" placeholder="Name of department" required>
        <textarea name="description_department" placeholder="Description of department" required><?=$session->getFormValues()['description']?></textarea>
        <button formaction="/../actions/action_add_department.php" formmethod="post">Add a new department</button>
    </form>

    <?php if ($session->getMessages()[0]['type'] !== null): ?>
      <div class=<?=$session->getMessages()[0]['type']?>>
        <p><?= $session->getMessages()[0]['text'] ?></p>
      </div>
    <?php endif; ?>
<?php } ?>

<?php function addElementsAdmin(Session $session) {?>
    <section id = "add_elements_admin">
        <h1>Create a new department</h1>
        <?php addDepartment($session) ?>
    </section>
<?php } ?>


<?php function drawUsers(PDO $db, Session $session, array $clients, array $agents, array $admins){ ?>
    <section id ="users">
        <div class="category">
            <h2>Clients</h2>
            <ul>
                <?php foreach ($clients as $client): ?>
                    <li class=client>
                        <div>
                            <p>Name: <?= $client->getName(); ?></p>
                            <p>Username: <?= $client->getUsername(); ?></p>
                            <p>Category: <?= $client->getCategory(); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="category">
            <h2>Agents</h2>
            <ul>
                <?php foreach ($agents as $agent): ?>
                    <li class=agent>
                        <div>
                            <p>Name: <?= $agent->getName(); ?></p>
                            <p>Username: <?= $agent->getUsername(); ?></p>
                            <p>Category: <?= $agent->getCategory(); ?></p>
                            <!-- Display departments -->
                            <p>Departments: 
                            <ul>
                            <?php
                            $departments = UserDepartment::getDepartmentsByAgent($db, $agent->getId());
                            foreach ($departments as $department):
                                $departmentName = Department::getDepartmentById($db, $department->getDepartmentId())->getName();
                                ?>
                                <li><?= $departmentName; ?></li>
                            <?php endforeach; ?>
                            </p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="category">
            <h2>Admins</h2>
            <ul>
                <?php foreach ($admins as $admin): ?>
                    <li class=admin>
                        <div>
                            <p>Name: <?= $admin->getName(); ?></p>
                            <p>Username: <?= $admin->getUsername(); ?></p>
                            <p>Category: <?= $admin->getCategory(); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php } ?>
