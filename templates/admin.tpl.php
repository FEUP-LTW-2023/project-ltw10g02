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
    
    <?php if (!empty($session->getMessages()) && isset($session->getMessages()[0]['type'])) {
        $messageType = $session->getMessages()[0]['type'];
        $messageText = $session->getMessages()[0]['text'];
        ?>
        <div class="<?= $messageType ?>">
            <p><?= $messageText ?></p>
        </div>
    <?php } ?>

    <section id ="users">
        <div class="category">
            <h2>Clients</h2>
            <ul>
                <?php foreach ($clients as $client): 
                    $userId=$client->getId();
                    ?>
                    <li class=client>
                        <div>
                            <p>Name: <?= $client->getName(); ?></p>
                            <p>Username: <?= $client->getUsername(); ?></p>
                            <p>Category: <?= $client->getCategory(); ?> 
                            <img id="edit_category_img" onclick ="redirectToPage('/../pages/edit_category.php?userId=<?= $userId ?>')" src="../images/icons/8666681_edit_icon.svg" alt="Edit category icon" />
                            </p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="category">
            <h2>Agents</h2>
            <ul>
                <?php foreach ($agents as $agent): 
                    $userId=$agent->getId();
                    ?>
                    <li class=agent>
                        <div>
                            <p>Name: <?= $agent->getName(); ?></p>
                            <p>Username: <?= $agent->getUsername(); ?></p>
                            <p>Category: <?= $agent->getCategory(); ?>
                            <img id="edit_category_img" onclick ="redirectToPage('/../pages/edit_category.php?userId=<?= $userId ?>')" src="../images/icons/8666681_edit_icon.svg" alt="Edit category icon" />
                            </p>
                            
                            <!-- Display departments -->
                            <p>Departments: 
                            <ul>
                            <?php
                            $departments = UserDepartment::getDepartmentsByAgent($db, $agent->getId());
                            foreach ($departments as $department):
                                $departmentName = Department::getDepartmentById($db, $department->getDepartmentId())->getName();
                                ?>
                                <li><?= $departmentName; ?>
                                <form action="../actions/action_remove_department.php" method="get">
                                    <input type="hidden" name="userId" value="<?= $userId ?>">
                                    <input type="hidden" name="departmentId" value="<?= $department->getDepartmentId() ?>">
                                    <button type="submit">remove</button>
                                </form>
                            <?php endforeach; ?>
                            <img id="edit_department_img" onclick ="redirectToPage('/../pages/assign_department.php?userId=<?= $userId ?>')" src="../images/icons/8666681_edit_icon.svg" alt="Edit department icon" />
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


<?php function drawUsersEditCategory(PDO $db, Session $session, array $clients, array $agents, array $admins, User $user){ ?>
    <section id ="users">
        <div class="category">
            <h2>Clients</h2>
            <ul>
                <?php foreach ($clients as $client): 
                    $userId=$client->getId();
                    ?>
                    <li class=client>
                        <div>
                            <p>Name: <?= $client->getName(); ?></p>
                            <p>Username: <?= $client->getUsername(); ?></p>
                            
                            <?php if ($userId == $user->getId()): ?>
    
                            <form action="/../actions/action_edit_category.php?userId=<?= $userId ?>" method="post">
                                <label for="category">Category: </label>
                                <select id="category" name="category">
                                    <option value="client" <?php if ($user->getCategory() === 'client') echo 'selected'; ?>>Client</option>
                                    <option value="agent" <?php if ($user->getCategory() === 'agent') echo 'selected'; ?>>Agent</option>
                                    <option value="admin" <?php if ($user->getCategory() === 'admin') echo 'selected'; ?>>Admin</option>
                                </select>
                                <input type="submit" value="Save changes">
                            </form>
                            
                            <?php else: ?>
                            <p>Category: <?= $client->getCategory(); ?>
                            </p>                        
                            <?php endif; ?>


                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="category">
            <h2>Agents</h2>
            <ul>
                <?php foreach ($agents as $agent): 
                    $userId=$agent->getId();
                    ?>
                    <li class=agent>
                        <div>
                            <p>Name: <?= $agent->getName(); ?></p>
                            <p>Username: <?= $agent->getUsername(); ?></p>
                            
                            <?php if ($userId == $user->getId()): ?>
                            
                            <form action="/../actions/edit_category.php?userId=<?= $userId ?>" method="post">
                                <label for="category">Category: </label>
                                <select id="category" name="category">
                                    <option value="client" <?php if ($user->getCategory() === 'client') echo 'selected'; ?>>Client</option>
                                    <option value="agent" <?php if ($user->getCategory() === 'agent') echo 'selected'; ?>>Agent</option>
                                    <option value="admin" <?php if ($user->getCategory() === 'admin') echo 'selected'; ?>>Admin</option>
                                </select>
                                <input type="submit" value="Save changes">
                            </form>
                            
                            <?php else: ?>
                            <p>Category: <?= $client->getCategory(); ?>
                            <img id="edit_category_img" onclick ="redirectToPage('/../pages/edit_category.php?user=<?= $userId ?>')" src="../images/icons/8666681_edit_icon.svg" alt="Edit category icon" />
                            </p>                        
                            <?php endif; ?>

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


<?php function drawUsersAssignDepartment(PDO $db, Session $session, array $clients, array $agents, array $admins, User $user){ ?>
    <section id ="users">
        <div class="category">
            <h2>Clients</h2>
            <ul>
                <?php foreach ($clients as $client): 
                    $userId=$client->getId();
                    ?>
                    <li class=client>
                        <div>
                            <p>Name: <?= $client->getName(); ?></p>
                            <p>Username: <?= $client->getUsername(); ?></p>
                            <p>Category: <?= $client->getCategory(); ?>
                            
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="category">
            <h2>Agents</h2>
            <ul>
                <?php foreach ($agents as $agent): 
                    $userId=$agent->getId();
                    ?>
                    <li class=agent>
                        <div>
                            <p>Name: <?= $agent->getName(); ?></p>
                            <p>Username: <?= $agent->getUsername(); ?></p>                            
                            <p>Category: <?= $client->getCategory(); ?>

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

                            <?php if ($userId == $user->getId()): 
                                $allDepartments=Department::getAllDepartments($db);
                            ?>
                            
                            <form>
                                <label>New department:
                                    <select name="department_id" required>
                                        <option value="">&mdash;</option>
                                        <?php foreach ($allDepartments as $departament): ?>
                                            <option value="<?=$departament->getId()?>"> <?= htmlentities($departament->getName()) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </label>
                            <input type="hidden" name="user_id" value = <?=$agent->getId()?>>
                            <button formaction="/../actions/action_assign_department.php" formmethod="post">Assign to agent</button>
                            </form>
                                                  
                            <?php endif; ?>

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
