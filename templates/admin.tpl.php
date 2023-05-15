<?php function addDepartment() {?>
    <form>
        <input type="text" name="name" pattern="[A-Za-zÀ-ú ]+" placeholder="Name of department" required>
        <input type="text" name="description" placeholder="Description" required>
        <button formaction="/../actions/action_add_department.php" formmethod="post">Add a new department</button>
    </form>
<?php } ?>