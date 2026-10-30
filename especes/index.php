<?php

/**
 * DÉMO utilisation du Système de Design Gouvernemental
 * 
 **/
$niveau = "../";
include($niveau . "inc/confinge.inc.php");

if (isset($_GET['id_page'])) {
    $strIdPage = max(0, (int) $_GET['id_page']);
} else {
    $strIdPage = 0;
}
if (isset($_GET['id_espece'])) {
    $strIdEspece = max(0, (int) $_GET['id_espece']);
} else {
    $strIdEspece = 0;
}
if (isset($_GET['id_groupe'])) {
    $strIdGroupe = max(0, (int) $_GET['id_groupe']);
} else {
    $strIdGroupe = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démo trousse SDG — Cégep</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="<?php echo $niveau . "Assets/sdg/dist/css/styles.css" ?>">

    <!-- Script des composants web de la trousse. -->
    <script defer src="<?php echo $niveau ?>assets/sdg/dist/js/qc-sdg.min.js"></script>
</head>
<?php
$nbEspeceParPage = 10; // Définir le nombre d'articles par page
$enregistrementDepart = $strIdPage * $nbEspeceParPage;
?>

<body>
    <header>
        <div id="pivEnteteExempleRecherchePersonnalisee">
            <qc-piv-header title-text="Objectif Biodiversité Québec"
                title-url
                alt-logo="Accédez à Québec.ca"
                enable-search="true"
                show-search="true">
                <ul slot="links">
                    <li><a href="#fakeEnglish">English</a>
                    </li>
                    <li><a href="#">Nous joindre</a>
                    </li>
                </ul>

                <form slot="search-zone"
                    method="get"
                    action="https://www.google.ca/search">
                    <qc-search-bar name="q"
                        piv-background></qc-search-bar>
                </form>
            </qc-piv-header>
        </div>

    </header>

    <main id="main">
        <div class="qc-container">
            <h1 class="qc-mb-4">Liste des espèces fauniques menacées ou vulnérables</h1>
            <section>
                <a href="index.php">Toutes</a> |
                <a href="index.php?statut_LEMV=menacée">Menacées</a> |
                <a href="index.php?statut_LEMV=vulnérable">Vulnérables</a>


            </section>
            <?php
            $strRequeteespece = "SELECT especes.id AS id_espece, nom_scientifique, nom_francais, statut_LEMV FROM especes";

            if (isset($_GET['statut_LEMV']) && $_GET['statut_LEMV'] != '' && ($_GET['statut_LEMV'] == 'menacée' || $_GET['statut_LEMV'] == 'vulnérable')) {
                $strRequeteespece .= " WHERE statut_LEMV = '" . $_GET['statut_LEMV'] . "'";
            }

            $strRequeteespece .= " ORDER BY nom_francais LIMIT " . $enregistrementDepart . ', ' . $nbEspeceParPage;
            if ($strIdGroupe != 0) {
                $strRequete2 = 'SELECT COUNT(*) AS nbEnregistrement FROM especes INNER JOIN groupes ON especes.id_groupe = groupes.id WHERE groupes.id=' . $strIdGroupe;
            } else {
                $strRequete2 = 'SELECT COUNT(*) AS nbEnregistrement FROM especes';
            }
            $resultat = $pdoConnexion->query($strRequeteespece);
            $section = $resultat->fetchAll(PDO::FETCH_ASSOC);
            $pdosResultat2 = $pdoConnexion->query($strRequete2);
            $totalespece2 = $pdosResultat2->fetch();
            $nbespece = $totalespece2['nbEnregistrement'];
            $nbPages = ceil($nbespece / $nbEspeceParPage);
            foreach ($section as $espece) {
                $strrequetegroupe = "SELECT groupes.id AS id_groupe, nom_groupe FROM groupes INNER JOIN especes ON groupes.id= especes.groupe_id WHERE especes.id= " . $espece["id_espece"];
                $pdoresultatgroupe = $pdoConnexion->query($strrequetegroupe);
                $ligneGroupe = $pdoresultatgroupe->fetchAll(PDO::FETCH_ASSOC);
                $strGroupe = ' ';
                foreach ($ligneGroupe as $groupe) {
                    $strGroupe = $strGroupe . $groupe["nom_groupe"] . "," . " ";
                }
                echo "<li>" . "<h3> <a href='fiche/index.php?id=" . $espece["id_espece"] . "'>"
                    . $espece["nom_francais"] . "</a></h3>" . " "
                    . "</li>" . "<p>Espece :" . $strGroupe . "</p>";
            }

            $resultat->closeCursor();
            $pdosResultat2->closeCursor();
            ?>
        </div>
        <div class="qc-pagination">
            <?php
            if ($strIdPage > 0) { ?>
                <a href='index.php?id_page=<?php echo ($strIdPage - 1); ?>&id_groupe=<?php echo ($strIdGroupe); ?>'>Page précédente</a>
                <?php }
            if ($nbPages > 1) {
                for ($cpt = 0; $cpt < $nbPages; $cpt++) { ?>
                    <?php if (isset($_GET['statut_LEMV']) && $_GET['statut_LEMV'] != '' && ($_GET['statut_LEMV'] == 'menacée' || $_GET['statut_LEMV'] == 'vulnérable')) { ?>
                        <a href='index.php?id_page=<?php echo ($cpt); ?>&id_groupe=<?php echo ($strIdGroupe); ?>&statut_LEMV=<?php echo ($_GET['statut_LEMV']); ?>'><?php echo ($cpt + 1); ?></a>
                    <?php } else { ?>
                        <a href='index.php?id_page=<?php echo ($cpt); ?>&id_groupe=<?php echo ($strIdGroupe); ?>'><?php echo ($cpt + 1); ?></a>
                    <?php }
                    ?>
                <?php } ?>


                <?php if ($strIdPage < $nbPages - 1) { ?>
                    <?php if (isset($_GET['statut_LEMV']) && $_GET['statut_LEMV'] != '' && ($_GET['statut_LEMV'] == 'menacée' || $_GET['statut_LEMV'] == 'vulnérable')) { ?>
                        <a href='index.php?id_page=<?php echo ($strIdPage + 1); ?>&id_groupe=<?php echo ($strIdGroupe); ?>&statut_LEMV=<?php echo ($_GET['statut_LEMV']); ?>'>Page suivante</a>
                    <?php } else { ?>
                        <a href='index.php?id_page=<?php echo ($strIdPage + 1); ?>&id_groupe=<?php echo ($strIdGroupe); ?>'>Page suivante</a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>


        </div>

        <p class="qc-pagination__info"> Page <?php echo " " . ($strIdPage + 1); ?> sur <?php echo ($nbPages); ?></p>

    </main>

    <footer>
        <qc-piv-footer>
            <nav aria-label="Navigation du pied de page">
                <ul>
                    <li><a href="<?php echo $niveau ?>index.php">Accueil</a></li>
                    <li><a href="https://design.quebec.ca" target="_blank" rel="noopener">Système de design gouvernemental</a></li>
                </ul>
            </nav>
        </qc-piv-footer>
    </footer>
</body>

</html>