<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/table.css">
</head>

<body>
    <?php
    session_start();
    include "C:/xampp/htdocs/projets php/php_p/php-projet/controllers/candidatController.php";
    include "../../controllers/userController.php";
    include "../../controllers/datesController.php";

    $adminId = $_SESSION["admin_id"];
    if ((string) $adminId === "0") {
        header("Location: adminConnexion.php");
    }

    $candidats = listCandidatsParNation("Togo");


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["valider"])) {
            $country = $_POST["nationalite"];
            $candidats = listCandidatsParNation($country);
        }
    }
    ?>
    <div class="sidebar">
        <?php include "../components/adminSidebar.php" ?>
    </div>

    <div class="table-container">
        <table border="1">
            <div style="display: flex; align-items:center; gap: 10px;">
                <p>Date du concours : <?php echo getConcDate()["date_conc"]; ?> </p>

                <form action="dateCandid.php">
                    <button type="submit" name="dateCandid">Modifier</button>
                </form>
            </div>
            <div style="display: flex; align-items:center; gap: 10px;">

                <p>Date limite de dépôt de candid : <?php echo getCandidDate()["date_lim_dep"]; ?></p>

                <form action="dateConc.php">
                    <button type="submit" name="dateConc">Modifier</button>
                </form>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <form action="" method="post">
                    <h4>Choisir le pays</h4>
                    <select name="nationalite" class="nationalite" id=""></select>
                    <button type="submit" name="valider">Valider</button>
                </form>
            </div>
            <caption>Liste des candidats inscrits par nationalité</caption>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Photo</th>
                <th>Date Naissance</th>
                <th>Sexe</th>
                <th>Nationalite</th>
                <th>Annee Bac</th>
                <th>Serie</th>
                <th>Copie Naissance</th>
                <th>Copie Nationalite</th>
                <th>Copie Attestation Bac</th>
            </tr>

            <?php
            foreach ($candidats as $candidat) {
                $username = getUsernameById($candidat["id_user"]);
            ?>

                <?php if (empty($candidat["nom"])) { ?>
                    <p>Les données ne sont pas disponibles pour ce pays</p>
                <?php  } else { ?>
                    <tr>
                        <td data-cell="Nom"><?php echo $candidat['nom']; ?></td>
                        <td data-cell="Prenom"><?php echo $candidat['prenom']; ?></td>
                        <td data-cell="Photo"><img src='../../uploads/<?php echo $username; ?>/photo/<?php echo $candidat['photo']; ?>' alt='Photo' width='50'></td>
                        <td data-cell="Date de naissance"><?php echo $candidat['date_naiss']; ?></td>
                        <td data-cell="Sexe"><?php echo $candidat['sexe']; ?></td>
                        <td data-cell="Nationalité"><?php echo $candidat['nationalite']; ?></td>
                        <td data-cell="Année d'obtention de BAC II"><?php echo $candidat['annee_bac2']; ?></td>
                        <td data-cell="Serie"><?php echo $candidat['serie']; ?></td>
                        <td data-cell="Copie de naissance"><a href="../../uploads/<?php echo $username; ?>/copie_naiss/<?php echo $candidat['copie_nais']; ?>">Voir</a></td>
                        <td data-cell="Copie de nationalité"><a href='../../uploads/<?php echo $username; ?>/copie_nation/<?php echo $candidat['copie_nation']; ?>'>Voir</a></td>
                        <td data-cell="Copie de l'attestation de BAC II"><a href='../../uploads/<?php echo $username; ?>/attest_bac/<?php echo $candidat['copie_attes_bac2']; ?>'>Voir</a></td>
                    </tr>
                <?php } ?>
            <?php } ?>

        </table>
    </div>

    <script src="../js/fetchCountriesApi.js"></script>
</body>

</html>