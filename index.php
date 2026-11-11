<?php
$niveau = '';

include($niveau . "inc/config.inc.php");

$strRequeteActualites = 'SELECT id, titre, auteur, date, texte, credit_photo
                        FROM actualites';

$pdosResultatActualites = $pdoConnexion->query($strRequeteActualites);

$arrActualites = array();
$ligne = $pdosResultatActualites->fetch();
for ($cpt = 0; $ligne = $pdosResultatActualites->fetch(); $cpt++) {
    $arrActualites[$cpt]['id']  = $ligne['id'];
    $arrActualites[$cpt]['titre'] = $ligne['titre'];
    $arrActualites[$cpt]['auteur']  = $ligne['auteur'];
    $arrActualites[$cpt]['date']  = $ligne['date'];
    $arrActualites[$cpt]['credit_photo']  = $ligne['credit_photo'];

    $arrTitre = explode(" ", $ligne["titre"]);
    $nbrMots = count($arrTitre);
    $limiteTexte = 44 - $nbrMots;
    $arrTexte = explode(" ", $ligne["texte"]);
    if (count($arrTexte) > $limiteTexte) {
        array_splice($arrTexte, $limiteTexte);
    }
    $arrActualites[$cpt]["texte"] = implode(" ", $arrTexte);
}
$pdosResultatActualites->closeCursor();
shuffle($arrActualites);
$arrActualites = array_slice($arrActualites, 0, 3);

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p1</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="assets/sdg/dist/css/styles.css?v=<?php echo filemtime(__DIR__ . '/assets/sdg/dist/css/styles.css'); ?>">

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
        <nav class="nav-menu">
            <ul class="nav-menu__list">
                <li class="nav-menu__item">
                    <a class="nav-menu__link active" href="<?php echo $niveau; ?>index.php">Accueil</a>
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
        </nav>
    </header>
    <main>

        <figure class="image-hero">
            <img alt="Tortue Luth LouisabelleGagnon"
                src="assets/images/IMG_Pluvier-Siffleur_PierrePouliot_MELCCFP.jpg">
            <div>
                <h1 class="hero-text">Découvrir. Comprendre. Protéger</h1>
                <a href="especes/index.php" class="qc-button qc-primary">Découvrir les espèces</a>
            </div>
        </figure>
        <div class="qc-container">
            <h2>Actualités</h2>
            <div class="section">
                <?php for ($cpt = 0; $cpt < count($arrActualites); $cpt++) { ?>
                    <article class="article">
                        <figure class="images-actu">
                            <img alt="Image d'actualités de <?php echo $arrActualites[$cpt]['auteur']; ?>"
                                src="<?php echo $niveau ?>assets/images/photos-actualites/<?php echo $arrActualites[$cpt]['id'] . ".jpeg"; ?>">

                        </figure>
                        <p class="date"><?php echo $arrActualites[$cpt]['date']; ?></p>
                        <p class="titre-actu" style="font-weight:var(--qc-font-weight-content-bold);"><?php echo $arrActualites[$cpt]['titre']; ?></p>
                        <p>
                            <?php echo $arrActualites[$cpt]['texte']; ?>
                            <a href="#" aria-label="Lire la suite de l'article sur <?php echo $arrActualites[$cpt]['titre']; ?>">...</a>
                        </p>
                        <a class="lien" href="#" aria-label="Lire l'article sur <?php echo $arrActualites[$cpt]['titre']; ?>">Lire l'article</a>
                    </article>
                <?php } ?>
            </div>
            <h2> Status de protection</h2>
            <p><strong>Menacé</strong> : espèce, sous-espèce ou population dont la disparition est redoutée.</p>
            <div>
                <a href="especes/index.php?statut_LEMV=menacée" class="qc-button qc-secondary">Découvrir les espèces menacées</a>
            </div>
            <p><strong>Vulnérable</strong> : espèce, sous-espèce ou population dont la survie est jugée précaire. Sa disparition n’est pas redoutée à court ou à moyen terme.</p>
            <div>
                <a href="especes/index.php?statut_LEMV=vulnérable" class="qc-button qc-secondary">Découvrir les espèces vulnérables</a>
            </div>
        </div>
    </main>



    <footer>
        <div class="qc-footer">
            <div class="qc-footer__brand">
                <h4 class="qc-h4">Objectif Biodiversité Quebec</h4>
                <p class="qc-p"> Découvrir. Comprendre. Protéger </p>
            </div>
            <div class="qc-footer__nav-container">
                <nav aria-label="Navigation du pied de page" class="qc-footer__nav1">
                    <button class="qc-footer__nav1-toggle" type="button" aria-expanded="false" aria-controls="menu-nav__1">
                        <h5>coordonées</h5>
                    </button>
                    <ul class="menu-nav" id="menu-nav__1">
                        <li class="menu-nav__item"><a href="https://www.google.com/maps/place/675+Bd+Ren%C3%A9-L%C3%A9vesque+E,+Qu%C3%A9bec,+QC+G1R+5E9/@46.8080733,-71.2201551,17z/data=!3m1!4b1!4m6!3m5!1s0x4cb895d803657005:0xc07c977340c24317!8m2!3d46.8080733!4d-71.2175802!16zL20vMDhrbm45?entry=ttu&g_ep=EgoyMDI2MTEwMy4wIKXMDSoASAFQAw%3D%3D" class="footer__link--1">
                                675 Bd René-Lévesque E
                                Québec
                                QC G1R 5E9
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
                        <li class="menu-nav__item"><a href="<?php echo $niveau ?>especes/index.php">Espèces</a></li>
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
                    <li>
                        <a href="#">Accessibilité</a>
                    </li>
                    <li>
                        <a href="#">Conditions d’utilisation</a>
                    </li>
                    <li>
                        <a href="#">Confidentialité</a>
                    </li>
                    <li>
                        <a href="https://design.quebec.ca" target="_blank" rel="noopener">Système de design gouvernemental</a>
                    </li>
                </ul>
            </nav>
        </qc-piv-footer>
    </footer>
</body>

</html>