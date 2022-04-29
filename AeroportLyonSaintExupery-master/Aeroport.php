<?php
session_start();
if (!isset($_SESSION["prenom"]))
{
//header('Location: http://www.dicj.info/etu/2030647/AeroportLyonSaintExupery/AeroportLyonSaintExupery/inscription.php'); Normalement
//exit();
    echo "<script type='text/javascript'> window.location.href = 'Connexion.php'; </script>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Lyon Saint Exupery</title>
</head>

<body>

<p>
<ul class="menu">
    <li>
        <a href='Accueil.php'>Page d'accueil</a>
    </li>
    <li>
        <a href='VisualisationDesVols.php'>Visualisation des vols</a>
    </li>
</ul>
</p>

<form method="post" class="middle" action="Accueil.php">
    <table>
        <tr>
            <td>
                <label>Code d'aéroport <input type="text" name="codeAeroport"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Nom d'aéroport <input type="text" name="nomAeroport"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Numéro de téléphone <input type="text" name="numTel"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Heure GMT <input type="date" name="heureGMT" /></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Ville <input type="text" name="villeAeroport"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Créer"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Modifier"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Supprimer"/>
            </td>
        </tr>
    </table>
</form>
</body>
<?php
echo "<a href='Accueil.php>'>Accueil</a>";
echo "<a href='VisualisationDesVols.php'> Visualisation des vols</a>";
echo "<a href='Aeroport.php'>Aéroports</a>";
?>