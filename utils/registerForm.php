<?php 
    function storeFormValuesAndRedirect(Session $session) {
        $session->addFormValues(array('name' => htmlentities($_POST['name']), 'username' => htmlentities($_POST['username']), 'email' => htmlentities($_POST['email'])));
        die(header('Location: /../pages/register.php'));
    }
?>