<?php
include('../inc/functions.php');

$emp_no = $_GET['emp_no'] ?? '';
$employee = get_one_employee($emp_no);
$current = get_current_department($emp_no);

$error = '';
$success = false;

// Traitement du formulaire (méthode POST car on modifie la base)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_dept = $_POST['dept_no'] ?? '';
    $start = $_POST['from_date'] ?? '';

    if ($new_dept === '' || $start === '') {
        $error = "Veuillez choisir un département et une date de début.";
    } elseif ($current && $start < $current['from_date']) {
        // c. Erreur si la date de début est antérieure à celle du département actuel
        $error = "La date de début ($start) ne peut pas être antérieure à celle du département actuel (" . $current['from_date'] . ").";
    } else {
        change_department($emp_no, $new_dept, $start);
        $success = true;
        // a. On recharge le département courant pour vérifier qu'il a bien changé
        $current = get_current_department($emp_no);
    }
}

// b. La liste déroulante exclut le département actuel
$departments = get_departments_except($current ? $current['dept_no'] : '');
?>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../design/theme-dark/style.css">
    <title>Changer de département</title>
</head>

<body>
    <div class="container">
        <p class="btn btn-secondary"><a href="fiche.php?emp_no=<?= urlencode($emp_no) ?>">&larr; Retour à la fiche</a>
        </p>

        <?php if (!$employee) { ?>
            <h1>Employé introuvable</h1>
        <?php } else { ?>
            <h1>Changer le département de <?= $employee['first_name'] ?>     <?= $employee['last_name'] ?></h1>

            <?php if ($success) { ?>
                <p class="alert alert-success">Changement effectué.</p>
            <?php } ?>
            <?php if ($error !== '') { ?>
                <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
            <?php } ?>

            <!-- b. Département actuel affiché en haut, avec sa date de début -->
            <p>
                <strong>Département actuel :</strong>
                <?= $current ? $current['dept_name'] . ' (depuis le ' . $current['from_date'] . ')' : 'aucun' ?>
            </p>

            <div class="card">
                <form method="post" action="change_dept.php?emp_no=<?= urlencode($emp_no) ?>">
                    <div class="form-group">
                        <p>
                            Nouveau département :
                            <select name="dept_no" class="form-control">
                                <option value="">— Choisir —</option>
                                <?php foreach ($departments as $d) { ?>
                                    <option value="<?= $d['dept_no'] ?>"><?= $d['dept_name'] ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    </div>
                    <div class="form-group">
                        <p>Date de début : <input type="date" class="form-control" name="from_date"></p>
                    </div>
                    <p><input type="submit" class="btn" value="Changer de département"></p>
                </form>
            </div>
        <?php } ?>
    </div>

</body>

</html>