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
        die("Connexion échouée. Erreur : " . $e->getMessage());
    }


    $sqlClient = "SELECT nomClient AS 'Nom', ' ', prenomClient AS 'Prénom', noClient FROM tblClient ORDER BY Nom ASC";
    $sqlClientList = $conn->query($sqlClient);

    $sqlAeroports = "SELECT aeroportDepart AS 'Aéroport de départ', aeroportArrivee AS 'Aéroport arrivée', Bil.dateVol AS 'Date du vol',
    Bil.codeClasse AS 'Code classe', Bil.noBillet AS 'Numéro de billet', Vol.noVol
	FROM tblVol Vol
	JOIN tblBillet Bil
		ON Vol.noVol = Bil.noVol
	WHERE Bil.dateVol >= CURRENT_TIME";
    $sqlAeroportsList = $conn->query($sqlAeroports);

if (isset($_POST['nomClient']) && isset($_POST['prenomClient']) && isset($_POST['noTelClient']) && isset
    ($_POST['adresseClient']) && isset($_POST['escompte']))
{
    $sql = "INSERT INTO tblReservation (dateReservation, statutReservation, modePaiement, statutPaiement, noClient)";
    $sql .= " VALUES ('CURRENT_TIME', 'EN ATTENTE', 'DEBIT', 'NON PAYE', ".$_POST['noClient'].");";
    try {
        $conn->exec($sql);
        echo "<h3>Les billets ont bien été réservés</h3>";
    }
    catch (PDOException $e) {
        die("Réservation impossible : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Achat billets</title>
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

<form method="post" class="middle" action="AchatBillet.php">
    <table>
        <tr>
            <td>
                <label for="nomClient">Client</label>
                <select required name="nomClient">
                    <?php
                    while ($donnees = $sqlClientList->fetch())
                    {
                        echo "<option value=".$donnees['noClient'].">".$donnees['Nom'].$donnees[' '].$donnees['Prénom']."</option>";
                    }
                    $sqlClientList->closeCursor();
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <label for="Vol.noVol">Vol</label>
                <select required name="Vol.noVol">
                    <?php
                    while ($donnees = $sqlAeroportsList->fetch())
                    {
                        echo "<option value=".$donnees['Vol.noVol'].">".$donnees['Aéroport de départ'].$donnees[' '].$donnees['Aéroport arrivée'].$donnees[' '].$donnees['Date du vol'].$donnees[' '].$donnees['Code classe'].$donnees[' '].$donnees['Numéro de billet']."</option>";
                    }
                    $sqlAeroportsList->closeCursor();
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="action" value="insertion"/>
                <input type="submit" value="Réserver"/>
            </td>
        </tr>
    </table>
</form>

<footer class="bottom">
    <?php include("Footer.php") ?>
</footer>

</body>
</html>
