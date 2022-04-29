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


#Pour générer les listes de choix des FK
try {
    $sqlAeroportD = "SELECT DISTINCT nomAeroport, codeAeroport FROM tblAeroport ORDER BY nomAeroport ASC";
    $listAeroportD = $conn->query($sqlAeroportD);

    $sqlAeroportA = "SELECT DISTINCT nomAeroport, codeAeroport FROM tblAeroport ORDER BY nomAeroport ASC";
    $listAeroportA = $conn->query($sqlAeroportA);

    $sqlTypeAppareil = "SELECT DISTINCT descTypeAppareil, codeTypeAppareil FROM tblTypeAppareil ORDER BY descTypeAppareil ASC";
    $listAppareil = $conn->query($sqlTypeAppareil);

    $sqlCie = "SELECT DISTINCT codeCie, nomCie FROM tblCompagnieAerienne ORDER BY nomCie ASC";
    $listCie = $conn->query($sqlCie);
}
catch (PDOException $e) {
    die("Impossible de récupérer l'information de la base de donnée : " . $e->getMessage());
}



        #Si paramètres reçu en POST => on insert dans la BD
        if (isset($_POST['noVol']) && isset($_POST['aeroportDepart']) && isset($_POST['aeroportArrivee']) && isset
            ($_POST['heureDepart']) && isset($_POST['heureArrivee']) && isset($_POST['distance']) && isset($_POST['dureeTotale'])
            && isset($_POST['codeTypeAppareil']) && isset($_POST['codeCie']))
        {
            $sql = "INSERT INTO tblVol";
            $sql .= " VALUES ('".$_POST['noVol']."', '".$_POST['aeroportDepart']."', '".$_POST['aeroportArrivee']."', '".
                $_POST['heureDepart']."', '". $_POST['heureArrivee']."', '".$_POST['distance']."', '".$_POST['dureeTotale']."', '".
                $_POST['codeTypeAppareil']."', '".$_POST['codeCie']."');";
            try {
                $conn->exec($sql);
                echo "Ajout de l'aéroport à la base de données réussie.";
            }
            catch (PDOException $e) {
                die("Ajout du vol impossible : " . $e->getMessage());
            }
        }
?>
    <!DOCTYPE html>
    <html lang="fr">
    <meta charset="UTF-8">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title>Insertion de vol</title>
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

    <form method="post" class="middle" action="InsertionVol.php">
        <table>
            <tr>
                <td>
                    <label>Numéro de vol<input type="text" name="noVol" maxlength="5" /></label>
                </td>

            </tr>
            <tr>
                <td>
                    <label for="aeroportDepart">Aéroport de départ</label>
                    <select required name="aeroportDepart">
                        <?php
                        while ($donnees = $listAeroportD->fetch())
                        {
                            echo "<option value=".$donnees['codeAeroport'].">".$donnees['nomAeroport']."</option>";
                        }
                        $listAeroportD->closeCursor();
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="aeroportArrivee">Aéroport d'arrivée</label>
                    <select required name="aeroportArrivee">
                        <?php
                        while ($donnees = $listAeroportA->fetch())
                        {
                            echo "<option value=".$donnees['codeAeroport'].">".$donnees['nomAeroport']."</option>";
                        }
                        $listAeroportA->closeCursor();
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Heure de départ<input type="time" required name="heureDepart" maxlength="6"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Heure d'arrivée<input type="time" required name="heureArrivee" maxlength="6"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Distance en KM<input type="text" required name="distance" maxlength="5"/></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Durée totale prévue<input type="text" required name="dureeTotale" maxlength="3"/></label>
                </td>
            </tr>




            <tr>
                <td>
                    <label for="codeTypeAppareil">Appareil</label>
                    <select required name="codeTypeAppareil">
                        <?php
                        while ($donnees = $listAppareil->fetch())
                        {
                            echo "<option value=".$donnees['codeTypeAppareil'].">".$donnees['descTypeAppareil']."</option>";
                        }
                        $listAppareil->closeCursor();
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="codeCie">Compagnie aérienne</label>
                    <select required name="codeCie">
                        <?php
                        while ($donnees = $listCie->fetch())
                        {
                            echo "<option value=".$donnees['codeCie'].">".$donnees['nomCie']."</option>";
                        }
                        $listCie->closeCursor();
                        ?>
                    </select>
                </td>
            </tr>



            <tr>
                <td>
                    <input type="hidden" name="action" value="insertion"/>
                    <input type="submit" value="Ajouter un vol"/>
                </td>
            </tr>
        </table>
    </form>

    <footer class="bottom">
        <?php include("Footer.php") ?>
    </footer>

    </body>
</html>