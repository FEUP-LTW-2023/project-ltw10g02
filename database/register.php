<?php
    function addUser(PDO $db, $name, $username, $password, $email, $category){
        $stmt = $db->prepare('INSERT INTO users (name, username, pass, email, category) VALUES(?, ?, ?, ?, ?)');
        $stmt->execute(array($name, $username, $password, $email, $category));
    }
?>