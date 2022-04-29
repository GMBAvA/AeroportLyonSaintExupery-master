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

    $_prenom = "";
    $_nom = "";
    $_username = "";
    $_mdp = "";

    $sql1 = "SELECT Vol.noVol,' ', COUNT(noBillet) AS 'Nombre de billets vendus par vol'
FROM tblVol AS Vol
JOIN tblBillet Billet
	ON Billet.noVol = Vol.noVol
GROUP BY Vol.noVol";
    $reponse1 = $conn->query($sql1);

    $sql2 = "SELECT Vol.noVol,' ', COUNT(noBillet) AS 'Nombre de billets vendus par vol ayant des passagers'
FROM tblVol AS Vol
JOIN tblBillet AS Billet
	ON Billet.noVol = Vol.noVol
JOIN tblReservation AS Reservation
	ON Reservation.noReservation = Billet.noReservation
JOIN tblClient AS Client
	ON  Reservation.noClient = Client.noClient
GROUP BY Vol.noVol";
    $reponse2 = $conn->query($sql2);

    $sql3 = "SELECT Aeroport.nomAeroport,' ', COUNT(noBillet) AS 'Nombre de billets vendus par aéroport départ ou arrivée'
FROM tblAeroport AS Aeroport
JOIN tblVol AS Vol
	ON Aeroport.codeAeroport = Vol.aeroportDepart OR Aeroport.codeAeroport = Vol.aeroportArrivee
JOIN tblBillet AS Billet
	ON Billet.noVol = Vol.noVol
JOIN tblReservation AS Reservation
	ON Reservation.noReservation = Billet.noReservation
JOIN tblClient AS Client
	ON  Reservation.noClient = Client.noClient
GROUP BY Aeroport.nomAeroport";
    $reponse3 = $conn->query($sql3);

    $sql4 = "SELECT Aeroport.nomAeroport,' ', AVG(dureeTotalePrevue) AS 'Moyenne de durée de vol par aéroport'
FROM tblAeroport AS Aeroport
JOIN tblVol AS Vol
	ON Aeroport.codeAeroport = Vol.aeroportDepart OR Aeroport.codeAeroport = Vol.aeroportArrivee
GROUP BY Aeroport.nomAeroport";
    $reponse4 = $conn->query($sql4);

    $sql5 = "SELECT CONCAT(Client.nomClient,' ', Client.prenomClient) AS 'Client', SUM(prixBillet) AS 'Somme des achats de billets'
FROM tblClient AS Client
JOIN tblReservation AS Resa
	ON Resa.noClient = Client.noClient
JOIN tblBillet AS Billet
	ON Billet.noReservation = Resa.noReservation
GROUP BY CONCAT(Client.nomClient,' ', Client.prenomClient)";
    $reponse5 = $conn->query($sql5);
?>
    <!DOCTYPE html>
    <html lang="fr">
    <meta charset="UTF-8">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title>Statistiques des vols</title>
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

<table>
    <tr>
        <th colspan="9">
            Statistiques
        </th>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>
                        Numéro de vol
                    </td>
                    <td>
                        Nombre de billets vendus par vol
                    </td>
                </tr>
                <?php
                while ($donnees = $reponse1->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['noVol']."</td>";
                    echo "<td>".$donnees['Nombre de billets vendus par vol']."</td>";
                    echo "</tr>";
                }
                $reponse1->closeCursor();
                ?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        Numéro de vol
                    </td>
                    <td>
                        Nombre de billets vendus par vol ayant des passagers
                    </td>
                </tr>
                <?php
                while ($donnees = $reponse2->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['noVol']."</td>";
                    echo "<td>".$donnees['Nombre de billets vendus par vol ayant des passagers']."</td>";
                    echo "</tr>";
                }
                $reponse2->closeCursor();
                ?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        Nom aéroport
                    </td>
                    <td>
                        Nombre de billets vendus par vol ayant des passagers
                    </td>
                </tr>
                <?php
                while ($donnees = $reponse3->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['nomAeroport']."</td>";
                    echo "<td>".$donnees['Nombre de billets vendus par aéroport départ ou arrivée']."</td>";
                    echo "</tr>";
                }
                $reponse3->closeCursor();
                ?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        Nom aéroport
                    </td>
                    <td>
                        Nombre de billets vendus par vol ayant des passagers
                    </td>
                </tr>
                <?php
                while ($donnees = $reponse4->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['nomAeroport']."</td>";
                    echo "<td>".$donnees['Moyenne de durée de vol par aéroport']."</td>";
                    echo "</tr>";
                }
                $reponse4->closeCursor();
                ?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        Nom client
                    </td>
                    <td>
                        Somme des achats de billets
                    </td>
                </tr>
                <?php
                while ($donnees = $reponse5->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Client']."</td>";
                    echo "<td>".$donnees['Somme des achats de billets']."</td>";
                    echo "</tr>";
                }
                $reponse5->closeCursor();
                ?>
            </table>
    </tr>
</table>
    </body>

    <?php include("Footer.php");?>
<?php
}
catch (PDOException $e) {
    die("Connexion échouée. Erreur : " . $e->getMessage());
}
?>

