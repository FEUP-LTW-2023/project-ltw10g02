<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn() || $session->getCategory() !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once(__DIR__ . '/../database/database_connection.php');
require_once(__DIR__ . '/../database/classes/user_department.php');

$db = getDatabaseConnection();

$userId = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$departmentId = isset($_POST['department_id']) ? $_POST['department_id'] : null;

if ($userId && $departmentId) {
    try {
        // Add the department-user association to the database
        UserDepartment::addDepartmentToUser($db, $userId, $departmentId);
        $session->addMessage('success', 'Department successfully assigned to agent');
    } catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
    }
}

header('Location: ../../pages/users.php');
exit();
?>
