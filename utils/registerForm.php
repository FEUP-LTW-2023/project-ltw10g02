<?php 
    function storeFormValuesAndRedirect(Session $session) {
        $session->addFormValues(array('name' => $_POST['name'], 'username' => $_POST['username'], 'email' => $_POST['email']));
        die(header('Location: /../pages/register.php'));
    }
?>