<?php
    session_start();

    if (!isset($_SESSION["prenom"]))
    {
        //header('Location: http://www.dicj.info/etu/2030647/AeroportLyonSaintExupery/AeroportLyonSaintExupery/inscription.php'); Normalement
        //exit();
        echo "<script type='text/javascript'> window.location.href = 'Connexion.php'; </script>";
    }

    $servername = "server.saglachosting.com";
    $username = "cegepjon_2030647";
    $password = "DICJ2030647";


try
{
    $conn = new PDO("mysql:host=$servername;dbname=cegepjon_2030647", $username, $password);
    $conn->setAttribute( PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
    //echo "Connexion réussie";

    $sqlTypeAppareil = "SELECT descTypeAppareil, codeTypeAppareil FROM tblTypeAppareil";
    $listAppareils = $conn->query($sqlTypeAppareil);

    $sqlCompagnie = "SELECT nomCie, codeCie FROM tblCompagnieAerienne";
    $listeCie = $conn->query($sqlCompagnie);

    $sqlAeroportArrive = "SELECT nomAeroport, codeAeroport FROM tblAeroport";
    $listeAeroportArrive = $conn->query($sqlAeroportArrive);

    $sqlAeroportDepart = "SELECT nomAeroport, codeAeroport FROM tblAeroport";
    $listAeroportDepart = $conn->query($sqlAeroportDepart);

    $sql = "SELECT noVol, heureDepart, heureArrivee, dureeTotalePrevue FROM tblVol ";
    $and =" AND ";
    $sqlBoolWhere = false;

    if(isset($_GET['typeAppareil']))
    {
        if (!$sqlBoolWhere)
        {
            $sql .= " WHERE ";
            $sqlBoolWhere = true;
        }
        $sql .= " codeTypeAppareil =".$_GET['typeAppareil']." ";
    }

    if(isset($_GET['Cie']))
    {
        if (!$sqlBoolWhere)
        {
            $sql .= " WHERE ";
            $sqlBoolWhere = true;
        }
        else
        {
            $sql .= $and;
        }
        $sql .= " codeCie =".$_GET['Cie']." ";
    }

    if(isset($_GET['AeroportArrive']))
    {
        if (!$sqlBoolWhere)
        {
            $sql .= " WHERE ";
            $sqlBoolWhere = true;
        }
        else
        {
            $sql .= $and;
        }
        $sql .= " codeCie =".$_GET['AeroportArrive']." ";
    }

    if(isset($_GET['AeroportDepart']))
    {
        if (!$sqlBoolWhere)
        {
            $sql .= " WHERE ";
            $sqlBoolWhere = true;
        }
        else
        {
            $sql .= $and;
        }
        $sql .= " codeCie =".$_GET['AeroportDepart']." ";
    }
    $sqlRes = $conn->query($sql);
}
catch (PDOException $e)
{
    die("Connexion échouée. Erreur : ".$e->getMessage());
}

    ?>

<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Visualisation des vols</title>
</head>

<body>

<?php include("Header.php"); ?>

<p>
<ul class="menu">
    <li>
        <a href='Accueil.php'>Page d'accueil</a>
    </li>
</ul>
</p>


<form method="get" action="VisualisationDesVols.php">
    <table>
        <tr>
            <td>
                <label for="typeAppareil">Type d'appareil</label>
                <select name="typeAppareil">
                <?php
                while ($donnees = $listAppareils->fetch())
                {
                    echo "<option value=".$donnees['codeTypeAppareil'].">".$donnees['descTypeAppareil']."</option>";
                }
                $listAppareils->closeCursor();
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="Cie">Compagnie</label>
                <select name="Cie"
                <?php
                while ($donnees = $listeCie->fetch())
                {
                    echo "<option value=".$donnees['codeCie'].">".$donnees['nomCie']."</option>";
                }
                $listeCie->closeCursor();
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="AeroportArrive">Aéroport d'arrivée</label>
                <select name="AeroportArrive"
                <?php
                while ($donnees = $listeAeroportArrive->fetch())
                {
                    echo "<option value=".$donnees['codeAeroport'].">".$donnees['nomAeroport']."</option>";
                }
                $listeAeroportArrive->closeCursor();
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="AeroportDepart">Aéroport de départ</label>
                <select name="AeroportDepart"
                <?php
                while ($donnees = $listAeroportDepart->fetch())
                {
                    echo "<option value=".$donnees['codeAeroport'].">".$donnees['nomAeroport']."</option>";
                }
                $listAeroportDepart->closeCursor();
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Voir les vols disponibles"/>
            </td>
        </tr>
    </table>
</form>

<table>

<form method="get" action="VisualisationDesVols.php">
    <table>
        <tr>
            <th>Code vol</th>
            <th>Heure de départ</th>
            <th>Heure d'arrivée</th>
            <th>Durée totale prévue</th>
        </tr>
        <?php
        while($donnees = $sqlRes->fetch())
        {
            echo "<tr>";
            echo "<td>".$donnees['noVol']."</td>";
            echo "<td>".$donnees['heureDepart']."</td>";
            echo "<td>".$donnees['heureArrivee']."</td>";
            echo "<td>".$donnees['dureeTotalePrevue']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</form>

</table>


<?php include "Menu.php" ?>
<?php include("Footer.php") ?>

</body>
</html>