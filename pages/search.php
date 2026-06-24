<?php
include('../inc/functions.php');

$departments = get_all_departments();

// Récupération des critères (?? '' évite le warning si le champ est absent)
$dept_no = $_GET['dept_no'] ?? '';
$name = $_GET['name'] ?? '';
$age_min = $_GET['age_min'] ?? '';
$age_max = $_GET['age_max'] ?? '';

// On ne lance la recherche que si le formulaire a été soumis
$submitted = isset($_GET['dept_no']);
$results = $submitted ? search_employees($dept_no, $name, $age_min, $age_max) : array();
?>
<html>

<head>
    <title>Recherche d'employés</title>
    <link rel="stylesheet" href="../design/theme-dark/style.css">
</head>

<body>
    <div class="container">
        <p class="btn btn-secondary"><a href="index.php">&larr; Retour aux départements</a></p>
        <h1 class="mt">Recherche d'employés</h1>

        <div class="card">
            <form method="get" action="search.php">
                <div class="form-group">
                    <label for="">Département :</label>
                    <select name="dept_no" class="form-control">
                        <option value="">— Tous —</option>
                        <?php foreach ($departments as $d) { ?>
                            <option value="<?= $d['dept_no'] ?>" <?= $dept_no === $d['dept_no'] ? 'selected' : '' ?>>
                                <?= $d['dept_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nom de l'employé : </label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name) ?>">
                </div>
                <div class="form-group">
                    <label for="">Âge min : </label>
                    <input type="number" class="form-control" name="age_min" value="<?= htmlspecialchars($age_min) ?>">
                </div>
                <div class="form-group">
                    <label for="">Âge max : </label>
                    <input type="number" class="form-control" name="age_max" value="<?= htmlspecialchars($age_max) ?>">
                </div>
                <p><input class="btn" type="submit" value="Rechercher"></p>
            </form>
        </div>

        <?php if ($submitted) { ?>
            <h2><?= count($results) ?> résultat(s)<?= count($results) === 200 ? ' (limité à 200)' : '' ?></h2>
            <table class="table">
                <tr>
                    <th>N°</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Genre</th>
                    <th>Âge</th>
                    <th>Département</th>
                </tr>
                <?php foreach ($results as $emp) { ?>
                    <tr>
                        <td><a href="fiche.php?emp_no=<?= urlencode($emp['emp_no']) ?>"><?= $emp['emp_no'] ?></a></td>
                        <td><?= $emp['first_name'] ?></td>
                        <td><?= $emp['last_name'] ?></td>
                        <td><?= $emp['gender'] ?></td>
                        <td><?= $emp['age'] ?></td>
                        <td><?= $emp['dept_name'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</body>

</html>