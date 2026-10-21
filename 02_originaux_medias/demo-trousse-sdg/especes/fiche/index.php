<?php 
/**
 * DÉMO utilisation du Système de Design Gouvernemental
 * 
 **/
$niveau = "../../";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démo trousse SDG — Cégep</title>

    <!-- Feuille de styles de la trousse (design gouvernemental). -->
    <link rel="stylesheet" href="<?php echo $niveau ?>assets/sdg/dist/css/qc-sdg.min.css">

    <!-- Script des composants web de la trousse. -->
    <script defer src="<?php echo $niveau ?>assets/sdg/dist/js/qc-sdg.min.js"></script>
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
        <h1 class="qc-h1"><span class="qc-subhead ">Fiche</span>Faucon pélerin</h1>
        <figure>
  <img src="<?php echo $niveau ?>assets/images/vulnerables/IMG_Faucon-pelerin_JeanLapointe.jpg"
       alt="Image avec légende">
  <figcaption>
    <p>Faucon pélerin<br>
      <em>Photo: Jean Lapointe</em>
    </p>
  </figcaption>
</figure>
 
    </div>
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