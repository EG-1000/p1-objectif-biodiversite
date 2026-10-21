<?php
/**
 * DÉMO utilisation du Système de Design Gouvernemental
 * 
 * Complet pour Design avec FIGMA : https://design.quebec.ca/design
 * 
 * Partiel pour Intégration : https://github.com/Quebecca/qc_trousse_sdg/
 * Afficher la documentation : /public/html
 * 
 * Les balises <qc-*> sont des composants web de la trousse SDG. Elles sont
 * « réveillées » par le script /assets/sdg/js/qc-sdg.min.js chargé plus bas.
 */

$niveau = "";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démo trousse SDG — Cégep</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg.min.css">
    <link rel="stylesheet" href="style.css">

    <!-- Script des composants web de la trousse. -->
    <script defer src="assets/sdg/dist/js/qc-sdg.min.js"></script>

</head>
<body>
<header>
    <qc-piv-header
            title-text="Démonstration — Système de design gouvernemental"
            alt-logo="Signature du gouvernement du Québec.">
    </qc-piv-header>
</header>

<main id="main" class="qc-container"> 
        <h1 class="qc-h1">Titre de niveau 1</h1>
<h1 id="exemple-titre-h1"
    class="qc-h1"><span class="qc-subhead ">Surtitre</span>Titre de niveau 1 avec surtitre
</h1>
<h2 class="qc-h2">Titre de niveau 2</h2>  
 <p class="accent">Un texte en accent et un <span> span. </span>
 </p> 
</main>

<footer>
    <qc-piv-footer>
        <nav aria-label="Navigation du pied de page">
            <ul>
                <li><a href="<?php echo $niveau ?>">Accueil</a></li>
                <li><a href="https://design.quebec.ca" target="_blank" rel="noopener">Système de design gouvernemental</a></li>
            </ul>
        </nav>
    </qc-piv-footer>
</footer>
</body>
</html>