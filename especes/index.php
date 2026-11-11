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
    <link rel="stylesheet" href="../assets/sdg/dist/css/styles.css">

    <!-- Script des composants web de la trousse. -->
    <script defer src="<?php echo $niveau ?>assets/sdg/dist/js/qc-sdg.min.js"></script>
    <script defer src="<?php echo $niveau ?>assets/sdg/dist/js/formulaire.js"></script>
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
            <form method="get" action="index.php">
                <?php if (isset($_GET['statut_LEMV']) && ($_GET['statut_LEMV'] == 'menacée' || $_GET['statut_LEMV'] == 'vulnérable')) { ?>
                    <input type="hidden" name="statut_LEMV" value="<?php echo $_GET['statut_LEMV']; ?>">
                <?php } ?>
                <label>Espèce :</label>
                <input type="radio" name="id_groupe" value="0" id="id_groupe_0" <?php echo $strIdGroupe == 0 ? 'checked' : ''; ?>> Toutes
                <?php
                $listeGroupes = $pdoConnexion->query("SELECT id, nom_groupe FROM groupes ORDER BY nom_groupe")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($listeGroupes as $g) { ?>
                    <input type="radio" name="id_groupe" value="<?php echo $g['id']; ?>" id="id_groupe_<?php echo $g['id']; ?>" <?php echo $strIdGroupe == $g['id'] ? 'checked' : ''; ?>> <?php echo htmlspecialchars($g['nom_groupe']); ?>
                <?php } ?>
                <noscript><input type="submit" value="Filtrer"></noscript>
            </form>
            <?php
            $arrWhere = [];
            if (isset($_GET['statut_LEMV']) && ($_GET['statut_LEMV'] == 'menacée' || $_GET['statut_LEMV'] == 'vulnérable')) {
                $arrWhere[] = "statut_LEMV = '" . $_GET['statut_LEMV'] . "'";
            }
            if ($strIdGroupe != 0) {
                $arrWhere[] = "especes.groupe_id = " . $strIdGroupe;
            }
            $strWhere = "";
            if (count($arrWhere) > 0) {
                $strWhere = " WHERE " . implode(" AND ", $arrWhere);
            }

            $strRequeteespece = "SELECT especes.id AS id_espece, nom_scientifique, nom_francais, statut_LEMV FROM especes" . $strWhere
                . " ORDER BY nom_francais LIMIT " . $enregistrementDepart . ', ' . $nbEspeceParPage;
            $strRequete2 = 'SELECT COUNT(*) AS nbEnregistrement FROM especes' . $strWhere;
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
                echo '<span class="qc-lozenge qc-' . $espece["statut_LEMV"] . '" aria-label="' . $espece["statut_LEMV"] . '">' . $espece["statut_LEMV"] . '</span>' . "<li>" . "<h3> <a href='fiche/index.php?id=" . $espece["id_espece"] . "'>"
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

        <div class="qc-pagination__info"> Page <?php echo " " . ($strIdPage + 1); ?> sur <?php echo ($nbPages); ?></div>

    </main>

    <footer>
        <div class="qc-footer">
            <h4>Objectif Biodiversité Quebec</h4>
            <p> Découvrir. Comprendre. Protéger </p>
            <div class="qc-footer__nav-container">
                <nav aria-label="Navigation du pied de page" class="qc-footer__nav1">
                    <button class="qc-footer__nav1-toggle" type="button" aria-expanded="false" aria-controls="menu-nav__1">
                        <h5>coordonées</h5>
                    </button>
                    <ul class="menu-nav" id="menu-nav__1">
                        <li class="menu-nav__item"><a href="https://www.google.com/maps/place/675+Bd+Ren%C3%A9-L%C3%A9vesque+E,+Qu%C3%A9bec,+QC+G1R+5E9/@46.8080733,-71.2201551,17z/data=!3m1!4b1!4m6!3m5!1s0x4cb895d803657005:0xc07c977340c24317!8m2!3d46.8080733!4d-71.2175802!16zL20vMDhrbm45?entry=ttu&g_ep=EgoyMDI2MTEwMy4wIKXMDSoASAFQAw%3D%3D" class="footer__link--1">
                                <p>675 Bd René-Lévesque E </p>
                                <p> Québec </p>
                                <p> QC G1R 5E9 </p>
                            </a></li>
                    </ul>
                </nav>
                <nav aria-label="Navigation du pied de page" class="qc-footer__nav2">
                    <button class="qc-footer__nav2-toggle" type="button" aria-expanded="false" aria-controls="menu-nav__2">
                        <h5>menu</h5>
                    </button>
                    <ul class="menu-nav" id="menu-nav__2">
                        <li class="menu-nav__item"><a href="<?php echo $niveau ?>index.php">Accueil</a></li>
                        <li class="menu-nav__item"><a href="<?php echo $niveau ?>index.php">À propos</a></li>
                        <li class="menu-nav__item"><a href="index.php">Espèces</a></li>
                        <li class="menu-nav__item"><a href="<?php echo $niveau ?>index.php">Contact</a></li>
                    </ul>
                </nav>
                <nav aria-label="Navigation du pied de page" class="qc-footer__nav3">
                    <button class="qc-footer__nav3-toggle" type="button" aria-expanded="false" aria-controls="menu-nav__3">
                        <h5>suivez-nous</h5>
                    </button>
                    <ul class="menu-nav" id="menu-nav__3">
                        <li class="menu-nav__item"><a href="https://twitter.com" target="_blank" rel="noopener">Twitter</a></li>
                        <li class="menu-nav__item"><a href="https://www.facebook.com" target="_blank" rel="noopener">Facebook</a></li>
                        <li class="menu-nav__item"><a href="https://www.youtube.com" target="_blank" rel="noopener">YouTube</a></li>
                        <li class="menu-nav__item"><a href="https://www.instagram.com" target="_blank" rel="noopener">Instagram</a></li>
                    </ul>
                </nav>
            </div> <!-- Close qc-footer__nav-container -->
        </div>
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