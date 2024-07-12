<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="author" content="BIRETTE_BERTUCCI_FLAGEUL_PARIS"/>
    <meta name="DC.Title" content="VoirFaire">
    <meta name="DC.Creator" content="Hadrien PARIS & Cie">
    <meta name="DC.Date" content="2021">
    <meta name="DC.Format" content="text/html">
    <meta name="DC.Language" content="en">
    <title><?= $this->title ?></title>
    <script src="js/map.js"></script>
    <link href="css/screenNav.css" rel="stylesheet" type="text/css"/>
    <link href="css/screen.css" rel="stylesheet" type="text/css"/>
</head>
<header>
  <nav role="navigation">

        <ul id="menu">
        <?php
        foreach ($this->menu as $url => $texte) {
        echo " <li> <a href=\"$url\">$texte</a> </li>";
        }
        echo $this->menuConnexion;
        ?>

        </ul>

  </nav>

  <?= $this->displayFeedback(); ?>
</header>

<body>
<?= $this->content ?>
</body>
</html>
