<?php
$niveau = '';

include($niveau . "inc/config.inc.php");

$strRequeteActualites = 'SELECT id, titre, auteur, date, texte, credit_photo
               FROM actualites';

$pdosResultatActualites = $pdoConnexion->query($strRequeteActualites);

$arrActualites = array();
$ligne = $pdosResultatActualites->fetch();
for ($cpt = 0; $ligne= $pdosResultatActualites->fetch(); $cpt++) {
    $arrActualites[$cpt]['id']  = $ligne['id'];
    $arrActualites[$cpt]['titre']  = $ligne['titre'];
    $arrActualites[$cpt]['auteur']  = $ligne['auteur'];
    $arrActualites[$cpt]['date']  = $ligne['date'];
    $arrActualites[$cpt]['credit_photo']  = $ligne['credit_photo'];

    $arrArticle = explode(" ", $ligne["texte"]);
    if (count($arrArticle)> 44) {
        array_splice($arrArticle,44, count($arrArticle));
    }
    $arrActualites[$cpt]["texte"] = implode(" ", $arrArticle);
}
$pdosResultatActualites->closeCursor();
shuffle($arrActualites);
$arrActualites=array_slice($arrActualites,0, 3);

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p1</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="assets/sdg/dist/css/styles.css">

    <!-- Script des composants web de la trousse. -->
    <script defer src="assets/sdg/dist/js/qc-sdg.min.js"></script>

</head>

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
        <!-- <nav class="nav-menu">
            <ul class="nav-menu__list">
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>index.php">Accueil</a>
                </li>
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>especes/index.php">Espèces</a>
                </li>
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>#">À propos</a>
                </li>
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>#">Nous contacter</a>
                </li>
            </ul>
        </nav> -->
    </header>
    <main>
        <picture class="image">
            <source media="(max-width: 360px)"
                srcset="assets/images/IMG_Tortue-Luth_LouisabelleGagnon.jpg">
            <img class="img" src="assets/images/IMG_Tortue-Luth_LouisabelleGagnon.jpg" alt="Tortue Luth LouisabelleGagnon">
            <div>
                <a href="especes/index.php" class="qc-button qc-primary">Découvrir les espèces</a>
            </div>
        </picture>
        <h2>Actualités</h2>
        <?php for ($cpt = 0; $cpt < count($arrActualites); $cpt++) { ?>
        <section>
            <figure>
                <img alt="Image d'actualités de <?php echo $arrActualites[$cpt]['auteur']; ?>"
                    src="<?php echo $niveau ?>assets/images/photos-actualites/<?php echo $arrActualites[$cpt]['id'] . ".jpeg"; ?>">
                <figcaption>
                    <p><?php echo $arrActualites[$cpt]['titre']; ?><br>
                        <em><?php echo $arrActualites[$cpt]['credit_photo']; ?></em>
                    </p>
                </figcaption>
            </figure>
            <p><?php echo $arrActualites[$cpt]['date']; ?></p>
            <header>
                <h3><?php echo $arrActualites[$cpt]['titre']; ?></h3>
            </header>
            
            <p>
                <?php echo $arrActualites[$cpt]['texte']; ?>
                <a href="#">...</a>
            </p>
            <a href="#">Lire l'article</a>
        </section>
        <?php } ?>
        <h2> Status de protection</h2>
        <p>Menacé : espèce, sous-espèce ou population dont la disparition est redoutée.</p>
        <div>
            <a href="especes/index.php?statut_LEMV=menacée" class="qc-button qc-secondary">Découvrir les espèces</a>
        </div>
        <p>Vulnérable : espèce, sous-espèce ou population dont la survie est jugée précaire. Sa disparition n’est pas redoutée à court ou à moyen terme.</p>
        <div>
            <a href="especes/index.php?statut_LEMV=vulnérable" class="qc-button qc-secondary">Découvrir les espèces</a>
        </div>

    </main>



    <footer>
        <h4>Gouvernement du Quebec</h4>
        <qc-piv-footer>
            <nav aria-label="Navigation du pied de page">
                <ul>
                    <li>Accessibilité</li>
                    <li>Conditions d’utilisation</li>
                    <li>Confidentialité</li>
                    <li><a href="https://design.quebec.ca" target="_blank" rel="noopener">Système de design gouvernemental</a></li>
                </ul>
            </nav>
        </qc-piv-footer>
    </footer>
</body>

</html>