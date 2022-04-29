<?php
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Lyon Saint Exupery</title>
</head>
<body class="php">

    <?php include("Header.php");?>

    <form method="post" class="middle" action="Accueil.php">
        <table>
            <tr>
                <td>
                    <label>Non d'utilisateur <input type="text" name="username"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Mot de passe <input type="password" name="password"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Nom de famille <input type="text" name="nomfamille"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Prénom <input type="text" name="prenom"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="action" value="inscription"/>
                    <input type="submit" value="S'inscrire"/>
                </td>
            </tr>
        </table>
    </form>

<footer class="bottom">
    <?php include("Footer.php") ?>
</footer>

</body>
</html>
