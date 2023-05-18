<?php function getUniqueDepartments($departments){ ?>
    <?php
    $uniqueDepartments = array();
    $departmentIds = array();

    foreach ($departments as $department) {
        $departmentId = $department->getId();

        // Verifica se o ID do departamento já foi adicionado ao array de IDs
        if (!in_array($departmentId, $departmentIds)) {
            $uniqueDepartments[] = $department;

            // Adiciona o ID do departamento ao array de IDs
            $departmentIds[] = $departmentId;
        }
    }

    return $uniqueDepartments;
    ?>
<?php } ?>