<?php 
    function storeFormValuesAndRedirect(Session $session) {
        $session->addFormValues(array('name' => htmlentities($_POST['name']), 'username' => htmlentities($_POST['username']), 'email' => htmlentities($_POST['email'])));
        die(header('Location: /../pages/register.php'));
    }

    function departmentRedirect(Session $session) {
        $session->addFormValues(array('name' => htmlentities($_POST['name_department']), 'description' => htmlentities($_POST['description_department'])));
        die(header('Location: /../pages/create_entities_admin.php'));
    }
?>