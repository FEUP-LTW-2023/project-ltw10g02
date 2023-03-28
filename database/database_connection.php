<?php

function getDatabaseConnection(){
    $db = new PDO('sqlite:' . __DIR__ . '/../database/tabelas.db');
    return $db;
}
?>