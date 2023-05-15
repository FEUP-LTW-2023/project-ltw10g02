<?php function addDepartment(Session $session) {?>
    <form id = "add_department">
        <input type="text" name="name_department" pattern="[A-Za-zÀ-ú ]+" value = "<?= $session->getFormValues()['name']?>" placeholder="Name of department" required>
        <textarea name="description_department" placeholder="Description of department" required><?=$session->getFormValues()['description']?></textarea>
        <button formaction="/../actions/action_add_department.php" formmethod="post">Add a new department</button>
    </form>

        <p><?= $session->getMessages()[0]['text'] ?></p>
<?php } ?>

<?php function addElementsAdmin(Session $session) {?>
    <section id = "add_elements_admin">
        <h1>Create a new department</h1>
        <?php addDepartment($session) ?>
    </section>
<?php } ?>

<?php function listUsers(Session $session) {?>
    <section id = "add_elements_admin">
        <h1>Create a new department</h1>
        <?php addDepartment($session) ?>
    </section>
<?php } ?>
