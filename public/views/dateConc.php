<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dateCandid.css">
</head>

<body>

    <?php
    // récupérer la date de la candidature;
    include "../../controllers/datesController.php";

    $dateConc = getConcDate();
    // echo $dateConc["date_lim_dep"];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newCandiDate = $_POST["new_conc_date"];
        modifyConcDate($newCandiDate);
    }
    ?>

    <?php include "../components/adminSidebar.php" ?>
    <h3>Modifier la date du concours</h3>

    <form action="" method="POST">
        <input type="date" name="new_conc_date" placeholder="date de candidature" value="<?php echo $dateConc["date_conc"]; ?>">
        <button type="submit">Modifier</button>
    </form>
</body>

</html>