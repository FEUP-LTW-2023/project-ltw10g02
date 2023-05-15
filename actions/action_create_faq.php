<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()){
        header("Location: ../index.php");
        exit();
    }

    require_once(__DIR__ . '/../database/database_connection.php');
    require_once(__DIR__ . '/../database/classes/faq.php');

    $db = getDatabaseConnection();

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Validate form data
    $errors = [];

    if (empty($question)) {
        $session->addMessage('error', 'Question is required.');
    }

    else if (empty($answer)) {
        $session->addMessage('error', 'Answer is required.');
    }

    else {
        $faq = new FAQ($question, $answer);
        $faq->save($db);
        $session->addMessage('success', 'FAQ created successfully.');
    }
    header('Location: ../pages/faqs.php'); 
    exit();
?>