<?php
$niveau = ' ';
include($niveau . "inc/confige.inc.php");

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p1</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg.min.css">
    <link rel="stylesheet" href="style.css">

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
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>index.php">Accueil</a></li>
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>especes/index.php">Espèces</a></li>
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>#">À propos</a></li>
                <li class="nav-menu__item">
                    <a class="nav-menu__link" href="<?php echo $niveau; ?>#">Nous contacter</a></li>
            </ul>
        </nav>
    </header>

    

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