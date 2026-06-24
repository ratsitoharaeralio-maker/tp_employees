<?php
include('../inc/functions.php');
$departments = get_all_departments();

?>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../design/theme-dark/style.css">
    <title>Les news</title>
</head>

<body>
    <nav class="navbar">
        <ul>
            <li class="brand">Liste des départements</li>
            <li><a href="search.php">🔍 Rechercher un employé</a></li>
            <li><a href="stats.php">📊 Statistiques par emploi</a></li>
            <li><a href="dept_form.php">➕ Ajouter un département</a></li>
            <li><a href="emp_form.php">➕ Ajouter un employé</a></li>
        </ul>
    </nav>
    <div class="container">
        <table class="table" border="1">
            <thead>
                <th>Department Number</th>
                <th>Department Name</th>
                <th>Manager actuel</th>
                <th>Nombre d'employés</th>
                <th>Action</th>
            </thead>
            <?php foreach ($departments as $line) { ?>
                <tbody>
                    <td><a href="employees.php?dept_no=<?= urlencode($line['dept_no']) ?>"><?= $line['dept_no'] ?></a></td>
                    <td><?= $line['dept_name'] ?></td>
                    <td><?= $line['manager_name'] ?? '—' ?></td>
                    <td><?= $line['nb_employees'] ?></td>
                    <td><a href="dept_form.php?dept_no=<?= urlencode($line['dept_no']) ?>">Éditer</a></td>
                </tbody>
            <?php } ?>
        </table>
    </div>

</body>

</html>