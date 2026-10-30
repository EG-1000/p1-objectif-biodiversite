<?php
$niveau = "../../";
include($niveau . "inc/config.inc.php");

if (isset($_GET['id'])) {
    $strIdEspece = max(0, (int) $_GET['id']);
} else {
    $strIdEspece = 0;
}
$strRequete = 'SELECT nom_francais, nom_scientifique, autres_noms_francais, statut_LEMV, nom_groupe,
 nom_image, `bas-de-vignette`, commentaires, description, repartition, etat_situation, habitat,
  alimentation, reproduction, comportement, menaces, statuts_des_populations, rang_S, competence_principale
               FROM especes
               INNER JOIN groupes ON especes.groupe_id= groupes.id
               INNER JOIN images ON especes.id= images.espece_id
               WHERE especes.id = ' . $strIdEspece . ' AND `est_aire-repartition` = 0';

$pdosResultat = $pdoConnexion->query($strRequete);

$arrEspeces = array();
$ligne = $pdosResultat->fetch();
for ($cpt = 0; $cpt < $pdosResultat->rowCount(); $cpt++) {
    $arrEspeces['nom_francais'] = $ligne['nom_francais'];
    $arrEspeces['nom_scientifique'] = $ligne['nom_scientifique'];
    $arrEspeces['autres_noms_francais']  = $ligne['autres_noms_francais'];
    $arrEspeces['statut_LEMV']  = $ligne['statut_LEMV'];
    $arrEspeces['nom_groupe']  = $ligne['nom_groupe'];
    $arrEspeces['nom_image']  = $ligne['nom_image'];
    $arrEspeces['bas-de-vignette']  = $ligne['bas-de-vignette'];
    $arrEspeces['commentaires']  = $ligne['commentaires'];
    $arrEspeces['description']  = $ligne['description'];
    $arrEspeces['repartition']  = $ligne['repartition'];
    $arrEspeces['etat_situation']  = $ligne['etat_situation'];
    $arrEspeces['habitat']  = $ligne['habitat'];
    $arrEspeces['alimentation']  = $ligne['alimentation'];
    $arrEspeces['reproduction']  = $ligne['reproduction'];
    $arrEspeces['comportement']  = $ligne['comportement'];
    $arrEspeces['menaces']  = $ligne['menaces'];
    $arrEspeces['statuts_des_populations']  = $ligne['statuts_des_populations'];
    $arrEspeces['rang_S']  = $ligne['rang_S'];
    $arrEspeces['competence_principale']  = $ligne['competence_principale'];
    $ligne = $pdosResultat->fetch();
}
$pdosResultat->closeCursor();

$strRequeteCarte = 'SELECT nom_image, `bas-de-vignette`
               FROM images
               WHERE `est_aire-repartition` = 1';

$pdosResultatCarte = $pdoConnexion->query($strRequeteCarte);

$arrCartes = array();
$ligne = $pdosResultatCarte->fetch();
for ($cpt = 0; $cpt < $pdosResultatCarte->rowCount(); $cpt++) {
    $arrCartes['nom_image']  = $ligne['nom_image'];
    $arrCartes['bas-de-vignette']  = $ligne['bas-de-vignette'];
    $ligne = $pdosResultatCarte->fetch();
}
$pdosResultatCarte->closeCursor();

$strRequeteMenaceeSimilaires = 'SELECT DISTINCT especes.id, especes.nom_francais
                         FROM especes
                         INNER JOIN groupes ON especes.groupe_id= groupes.id
                         WHERE statut_LEMV = "Menacée" AND especes.groupe_id
                         IN (SELECT groupe_id FROM especes WHERE especes.id = ' . $strIdEspece . ')';

$pdosResultatSim = $pdoConnexion->query($strRequeteMenaceeSimilaires);

$arrEspecesMenaceeSimilaires = array();
$ligneEspecesSim = $pdosResultatSim->fetch();
for ($cpt = 0; $cpt < $pdosResultatSim->rowCount(); $cpt++) {
    $arrEspecesMenaceeSimilaires[$cpt]['id']  = $ligneEspecesSim['id'];
    $arrEspecesMenaceeSimilaires[$cpt]['nom_francais'] = $ligneEspecesSim['nom_francais'];
    $ligneEspecesSim = $pdosResultatSim->fetch();
}
$pdosResultatSim->closeCursor();


$strRequeteVulSimilaires = 'SELECT DISTINCT especes.id, especes.nom_francais
                         FROM especes
                         INNER JOIN groupes ON especes.groupe_id= groupes.id
                         WHERE statut_LEMV = "Vulnérable" AND especes.groupe_id
                         IN (SELECT groupe_id FROM especes WHERE especes.id = ' . $strIdEspece . ')';

$pdosResultatSim = $pdoConnexion->query($strRequeteVulSimilaires);

$arrEspecesVulSimilaires = array();
$ligneEspecesSim = $pdosResultatSim->fetch();
for ($cpt = 0; $cpt < $pdosResultatSim->rowCount(); $cpt++) {
    $arrEspecesVulSimilaires[$cpt]['id']  = $ligneEspecesSim['id'];
    $arrEspecesVulSimilaires[$cpt]['nom_francais'] = $ligneEspecesSim['nom_francais'];
    $ligneEspecesSim = $pdosResultatSim->fetch();
}
$pdosResultatSim->closeCursor();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démo trousse SDG — Cégep</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="<?php echo $niveau . "Assets/sdg/dist/css/qc-sdg.min.css" ?>">

    <!-- Script des composants web de la trousse. -->
    <script defer src="<?php echo $niveau . "Assets/sdg/dist/js/qc-sdg.min.js" ?>"></script>
</head>

<body>
    <header>
        <qc-piv-header
            title-text="Démonstration — Système de design gouvernemental"
            alt-logo="Signature du gouvernement du Québec.">
        </qc-piv-header>
    </header>

    <main id="main">
        <div class="qc-container">
            <h1 class="qc-h1"><span class="qc-subhead ">Fiche</span><?php echo $arrEspeces['nom_francais']; ?></h1>
            <figure>
                <img alt="Image de l'espèce <?php echo $arrEspeces['nom_francais']; ?>"
                    src="<?php echo $niveau ?>assets/images/<?php echo $arrEspeces['nom_image']; ?>">

                <figcaption>
                    <p><?php echo $arrEspeces['nom_francais']; ?><br>
                        <em><?php echo $arrEspeces['bas-de-vignette']; ?></em>
                    </p>
                </figcaption>
            </figure>
            <p>Nom<br><?php echo $arrEspeces['nom_francais']; ?></p>
            <p>Nom scientifique<br><?php echo $arrEspeces['nom_scientifique']; ?></p>
            <p>Autres noms français<br><?php echo $arrEspeces['autres_noms_francais']; ?></p>
            <p>Statut<br><?php echo $arrEspeces['statut_LEMV']; ?></p>
            <p>Groupe<br><?php echo $arrEspeces['nom_groupe']; ?></p>
            <h2>Répartition</h2>
            <p><?php echo $arrEspeces['repartition']; ?></p>
            <figure>
                <img alt="Image de l'espèce <?php echo $arrEspeces['nom_francais']; ?>"
                    src="<?php echo $niveau ?>assets/images/<?php echo $arrCartes['nom_image']; ?>">

                <figcaption>
                    <p><?php echo $arrEspeces['nom_francais']; ?><br>
                        <em><?php echo $arrCartes['bas-de-vignette']; ?></em>
                    </p>
                </figcaption>
            </figure>
            <h2>Habitat</h2>
            <p><?php echo $arrEspeces['habitat']; ?></p>
            <h2>État de la situation</h2>
            <p><?php echo $arrEspeces['etat_situation']; ?></p>
            <h2>Alimentation</h2>
            <p><?php echo $arrEspeces['alimentation']; ?></p>
            <h2>Reproduction</h2>
            <p><?php echo $arrEspeces['reproduction']; ?></p>
            <h2>Comportement</h2>
            <p><?php echo $arrEspeces['comportement']; ?></p>
            <h2>Menaces</h2>
            <p><?php echo $arrEspeces['menaces']; ?></p>
            <h2>Espèces du même groupe</h2>
            <h3>Menacé</h3>
            <ul>
                <?php for ($cpt = 0; $cpt < count($arrEspecesMenaceeSimilaires); $cpt++) { ?>
                <li>
                    <a href="index.php?id=<?php echo $arrEspecesMenaceeSimilaires[$cpt]['id']; ?>">
                    <?php echo $arrEspecesMenaceeSimilaires[$cpt]['nom_francais']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <h3>Vulnérables</h3>
            <ul>
                <?php for ($cpt = 0; $cpt < count($arrEspecesVulSimilaires); $cpt++) { ?>
                <li>
                    <a href="index.php?id=<?php echo $arrEspecesVulSimilaires[$cpt]['id']; ?>">
                    <?php echo $arrEspecesVulSimilaires[$cpt]['nom_francais']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
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