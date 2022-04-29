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
try {


    $sql1 = "SELECT nomPays as 'Pays', COUNT(codeAeroport) as 'Nombre aéroports'
    FROM tblAeroport Air 
    JOIN tblVille Ville 
        ON Air.codeVille = Ville.codeVille 
    JOIN tblPays Pays 
        ON Ville.codePays = Pays.codePays 
    GROUP BY Pays  
    ORDER BY `Nombre aéroports`  DESC";
    $sql1List = $conn->query($sql1);

    $sql2 = "SELECT nomVille AS 'Ville sans aéroport'
    FROM tblVille Ville
        JOIN tblAeroport Air
        ON Ville.codeVille = Air.codeVille
    GROUP BY nomVille
    HAVING COUNT(codeAeroport = 0)";
    $sql2List = $conn->query($sql2);

    $sql3 = "SELECT nomAeroport AS 'Aéroport de départ', nomAeroport AS 'Aéroport arrivée', Vol.noVol AS 'Numéro de vol', Bil.dateVol AS 'Date du vol'
    FROM tblAeroport Air
        JOIN tblVol Vol
    ON Air.codeAeroport = Vol.aeroportDepart OR Air.codeAeroport = Vol.aeroportArrivee
        JOIN tblBillet Bil
    ON Vol.noVol = Bil.noVol
    WHERE Bil.prixBillet < (SELECT AVG(prixBillet) AS 'Moyenne'
                            FROM tblBillet)";
    $sql3List = $conn->query($sql3);

    $sql4 = "SELECT nomClient, prenomClient, Vol.noVol
    FROM tblClient Cli
    
    JOIN tblReservation Resa
        ON Cli.noClient = Resa.noClient
    JOIN tblBillet Bil
        ON Resa.noReservation = Bil.noReservation
    JOIN tblVol Vol
        ON Bil.noVol = Vol.noVol
    WHERE Bil.typeRepas LIKE '%DÉJEUNER%'";
    $sql4List = $conn->query($sql4);

    $sql5 = "SELECT COUNT(noBillet) AS 'Nombre de billets', Cls.nomClasse AS 'Classe'
    FROM tblBillet Bil
    JOIN tblClasseBillet Cls
        ON Cls.codeClasse = Bil.codeClasse
    GROUP BY Cls.nomClasse";
    $sql5List = $conn->query($sql5);

    $sql6 = "SELECT nomClient AS 'Nom client', prenomClient AS 'Prénom client'
    FROM tblClient Cli
    JOIN tblReservation Resa
        ON Cli.noClient = Resa.noClient
    JOIN tblBillet Bil
        ON Resa.noReservation = Bil.noReservation
    WHERE Bil.codeClasse = 'CA'";
    $sql6List = $conn->query($sql6);

    $sql7 = "SELECT COUNT(noVol) AS 'Nombre de vols' , Cie.codeCie AS 'Code de compagnie aérienne'
    FROM tblVol Vol
    JOIN tblCompagnieAerienne Cie
        ON Vol.codeCie = Cie.codeCie
    GROUP BY Cie.codeCie";
    $sql7List = $conn->query($sql7);

    $sql8 = "SELECT COUNT(Cli.noClient) AS 'Nombre de passagers', Ville.nomVille AS 'Ville'
    FROM tblClient Cli
    JOIn tblReservation Resa
        ON Cli.noClient = Resa.noClient
    JOIN tblBillet Bil
        ON Resa.noReservation = Bil.noReservation
    JOIN tblVol Vol
        ON Bil.noVol = Vol.noVol
    JOIN tblAeroport Air
        ON Vol.aeroportArrivee = Air.codeAeroport
    JOIN tblVille Ville
        ON Air.codeVille = Ville.codeVille
    GROUP BY Ville.nomVille
    ORDER BY Ville.nomVille ASC";
    $sql8List = $conn->query($sql8);

?>


<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Informations</title>
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
                    <th colspan="4">
                        Nombre d'aéroports par pays
                    </th>

                </tr>
                <?php
                    echo "<tr>";
                    echo "<th>Pays<th>";
                    echo "<th>Aéroports<th>";
                    echo "</tr>";
                while ($donnees = $sql1List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Pays']."</td>";
                    echo "<td>".$donnees['Nombre aéroports']."</td>";
                    echo "</tr>";
                }
                $sql1List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th>
                        Villes sans aéroport
                    </th>
                </tr>
                <?php
                while ($donnees = $sql2List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Ville sans aéroport']."</td>";
                    echo "</tr>";
                }
                $sql2List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th colspan="7">
                        Informations pour les vols dont le prix du billet est inférieur à la moyenne des prix des billets.
                    </th>
                </tr>
                <?php
                echo "<tr>";
                echo "<th>Aéroport de départ<th>";
                echo "<th>Aéroport d'arrivée<th>";
                echo "<th>Numéro de vol<th>";
                echo "<th>Date du vol<th>";
                echo "</tr>";
                while ($donnees = $sql3List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Aéroport de départ']."</td>";
                    echo "<td>".$donnees['Aéroport arrivée']."</td>";
                    echo "<td>".$donnees['Numéro de vol']."</td>";
                    echo "<td>".$donnees['Date du vol']."</td>";
                    echo "</tr>";
                }
                $sql3List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th colspan="9">
                        Informations clients avec type de repas déjeuner
                    </th>
                </tr>
                <?php
                echo "<tr>";
                echo "<th>Nom<th>";
                echo "<th>Prénom<th>";
                echo "<th>Numéro de vol<th>";
                echo "</tr>";
                while ($donnees = $sql4List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['nomClient']."</td>";
                    echo "<td>".$donnees['prenomClient']."</td>";
                    echo "<td>".$donnees['Vol.noVol']."</td>";
                    echo "</tr>";
                }
                $sql4List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th colspan="9">
                        Nombre de billets par classe
                    </th>
                </tr>
                <?php
                echo "<tr>";
                echo "<th>Nombre de billets<th>";
                echo "<th>Classe<th>";
                echo "</tr>";
                while ($donnees = $sql5List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Nombre de billets']."</td>";
                    echo "<td>".$donnees['Classe']."</td>";
                    echo "</tr>";
                }
                $sql5List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th colspan="9">
                        Clients en classe affaire
                    </th>
                </tr>
                <?php
                echo "<tr>";
                echo "<th>Nom<th>";
                echo "<th>Prénom<th>";
                echo "</tr>";
                while ($donnees = $sql6List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Nom client']."</td>";
                    echo "<td>".$donnees['Prénom client']."</td>";
                    echo "</tr>";
                }
                $sql6List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th colspan="9">
                        Nombre de vols par compagnie aérienne
                    </th>
                </tr>
                <?php
                echo "<tr>";
                echo "<th>Nombre de vols<th>";
                echo "<th>Compagnie<th>";
                echo "</tr>";
                while ($donnees = $sql7List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Nombre de vols']."</td>";
                    echo "<td>".$donnees['Code de compagnie aérienne']."</td>";
                    echo "</tr>";
                }
                $sql7List->closeCursor();?>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th colspan="9">
                        Nombre de passagers atterrissant par ville
                    </th>
                </tr>
                <?php
                echo "<tr>";
                echo "<th>Nombre de passagers<th>";
                echo "<th>Ville<th>";
                echo "</tr>";
                while ($donnees = $sql8List->fetch())
                {
                    echo "<tr>";
                    echo "<td>".$donnees['Nombre de passagers']."</td>";
                    echo "<td>".$donnees['Ville']."</td>";
                    echo "</tr>";
                }
                $sql8List->closeCursor();

                }
                catch (PDOException $e) {
                    die("Connexion échouée. Erreur : " . $e->getMessage());
                }
                ?>
            </table>
    </tr>
</table>

<footer class="bottom">
    <?php include("Footer.php") ?>
</footer>

</body>
</html>
