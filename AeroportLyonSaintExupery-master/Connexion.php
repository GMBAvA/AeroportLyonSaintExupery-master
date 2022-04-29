<?php
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">

<head>
    <title>Lyon Saint Exupery</title>
    <h1>Bienvenue sur le site non-officiel de l'aéroport de Lyon Saint Exupéry</h1>
</head>

<body>

<h2 class="middle">Informations de connection :</h2>
<form method="post" class="middle" action="Accueil.php">
    <table>
        <tr>
            <td>
                <label>Courriel <input type="email" name="email"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Nom d'utilisateur <input type="text" name="username"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Mot de passe <input type="password" name="password"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Se connecter"/>
            </td>
        </tr>
        <tr>
            <td>
                <button><label>S'inscrire</label></button>
            </td>
        </tr>
    </table>
</form>

<footer class="bottom">
    <p> <div>Fait par Alexandre Berthoumieu</div> <div>Contactez nous via l'adresse suivante : 2030647@etu.cegepjonquiere.ca</div></p>
</footer>

</body>
</html>
