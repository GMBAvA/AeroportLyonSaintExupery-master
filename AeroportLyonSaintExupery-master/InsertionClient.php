<?php
session_start();

if (!isset($_SESSION["prenom"]))
{
    //header('Location: http://www.dicj.info/etu/2030647/AeroportLyonSaintExupery/AeroportLyonSaintExupery/inscription.php'); Normalement
    //exit();
    echo "<script type='text/javascript'> window.location.href = 'Connexion.php'; </script>";
}

    try {
        $servername = "server.saglachosting.com";
        $username = "cegepjon_2030647";
        $password = "DICJ2030647";
        $conn = new PDO("mysql:host=$servername;dbname=cegepjon_2030647", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $servername = "server.saglachosting.com";
        $username = "cegepjon_2030647";
        $password = "DICJ2030647";

    }
    catch (PDOException $e) {
        die("Connexion à la base de donnée échouée. Erreur : " . $e->getMessage());
    }

    #Si paramètres reçu en POST => on insert dans la BD
    if (isset($_POST['nomClient']) && isset($_POST['prenomClient']) && isset($_POST['noTelClient']) && isset
        ($_POST['adresseClient']) && isset($_POST['escompte']))
    {
        $sql = "INSERT INTO tblClient(nomCLient, prenomClient, noTelClient, adresseClient, escompte)";
        $sql .= " VALUES ('".$_POST['nomClient']."', '".$_POST['prenomClient']."', '".$_POST['noTelClient']."', '".
            $_POST['adresseClient']."', ". $_POST['escompte'].");";
        try {
            $conn->exec($sql);
            echo "Ajout du client à la base de données réussie.";
        }
        catch (PDOException $e) {
            die("Ajout impossible : " . $e->getMessage());
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Insertion de client</title>
</head>
<body class="php">

<?php include("Header.php");?>

<p>
<ul class="menu">
    <li>
        <a href='Accueil.php'>Page d'accueil</a>
    </li>
</ul>
</p>

<form method="post" class="middle" action="InsertionClient.php">
    <table>
        <tr>
            <td>
                <label>Nom<input type="text" name="nomClient" maxlength="25"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Prénom<input type="text" name="prenomClient" maxlength="25"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Téléphone<input type="number" name="noTelClient" maxlength="14"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Adresse<input type="text" name="adresseClient" maxlength="50"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Escompte<input type="number" name="escompte" value="0.0"/></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="action" value="insertion"/>
                <input type="submit" value="Ajouter un client"/>
            </td>
        </tr>
    </table>
</form>

<footer class="bottom">
    <?php include("Footer.php") ?>
</footer>

</body>
</html>