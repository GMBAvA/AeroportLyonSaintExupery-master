    <?php
    session_start();
    /* $_email = "";
    $_mdp = "";
    $_user = "";

    $isConnected = false;

    $_urlPHP = $_SERVER['PHP_SELF'];
    $_urlDICJ = "http://www.dicj.info/etu/2030647/AeroportLyonSaintExupery/AeroportLyonSaintExupery/LyonSaintExupery.html";

    if (isset($_POST["email"]) && isset($_POST["password"]))
    {
        $_email = $_POST["email"];
        $_mdp = $_POST["password"];
    }

    $xmlUser = simplexml_load_file("user.xml") or die ();

    foreach($xmlUser->children() as $user)
    {
        if ($_email == $user->mail && $_mdp == $user->mdp)
        {
            $_user = $user->prenom. " " . $user->nom;
            $isConnected = true;
            break;
        }
    }
    if ($isConnected == false &&  $_urlPHP != "LyonSaintExupery.html")
    {
        flush();
        //header('Location:http//www.example.com');//.$_urlDICJ);  WTF /////////////////////////////////////////////////
        echo "<script type='text/javascript'> document.location = 'LyonSaintExupery.html'; </script>";
        exit();
    } */

    if (!isset($_SESSION["prenom"]))
    {
        //header('Location: http://www.dicj.info/etu/2030647/AeroportLyonSaintExupery/AeroportLyonSaintExupery/inscription.php'); Normalement
        //exit();
        echo "<script type='text/javascript'> window.location.href = 'Connexion.php'; </script>";
    }

    $servername = "server.saglachosting.com";
    $username = "cegepjon_2030647";
    $password = "DICJ2030647";

    $_prenom = "";
    $_nom = "";
    $_username = "";
    $_mdp = "";

    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=cegepjon_2030647", $username, $password);
        $conn->setAttribute( PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
        //echo "Connexion réussie";



        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nomfamille']) && isset($_POST['prenom']))
        {
            $inscr = "INSERT INTO tblUsagers (nomUsager, pwdUsager, nomUtilisateur, prenomUtilisateur, dateCreation) VALUES ('".$_POST['username']."', '".$_POST['password']."', '".$_POST['nomfamille']."', '".$_POST['prenom']."', CURDATE())";
            $conn->query($inscr);
            echo "Inscription effectuée avec succès, veuillez confirmez votre adesse email";
        }


        $sqlBienvenue = "SELECT prenomUtilisateur, nomUtilisateur FROM tblUsagers WHERE nomUsager = '".$_POST['username']."' AND pwdUsager = '".$_POST['password']."'";
        $reponse = $conn->query($sqlBienvenue);
        while ($donnees = $reponse->fetch())
        {
            //echo "<p>"." Bonjour ". $donnees['prenomUtilisateur'] ." ". $donnees['nomUtilisateur'].  "</p>";
            $_SESSION["nom"] = $donnees['nomUtilisateur'];
            $_SESSION["prenom"] = $donnees['prenomUtilisateur'];
        }

        $reponse->closeCursor();



    }
    catch (PDOException $e) {
        die("Connexion échouée. Erreur : " . $e->getMessage());
    }
    ?>
<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body class="php">

    <?php include("Header.php");?>

    <p>
    <ul class="menu">
        <li>
            <a href='Connexion.php'>Connexion</a>
        </li>
        <li>
            <a href='Inscription.php'>Inscription</a>
        </li>
        <li>
            <a href='Connexion.php'>Déconnexion</a>
        </li>
        <li>
            <a href='VisualisationDesVols.php'>Visualisation des vols</a>
        </li>
        <li>
            <a href='Aeroport.php'>Aéroport</a>
        </li>
        <li>
            <a href='Statistiques.php'>Statistiques</a>
        </li>
        <li>
            <a href='InsertionClient.php'>Ajout client</a>
        </li>
        <li>
            <a href='InsertionVol.php'>Ajout vol</a>
        </li>
        <li>
            <a href='AchatBillet.php'>Acheter ses billet</a>
        </li>
        <li>
            <a href='Informations.php'>Informations</a>
        </li>
    </ul>
    </p>

    <?php
    if (isset($_POST['codeAeroport']) && isset($_POST['nomAeroport']) && isset($_POST['numTel']) && isset($_POST['heureGMT']) && isset($_POST['villeAeroport']))
    {
        $sql = "INSERT INTO tblAeroport (codeAeroport, nomAeroport, noTelAeroport, heureGMT, codeVille)";
        $sql .= " VALUES ('".$_POST['codeAeroport']."', '".$_POST['nomAeroport']."', '".$_POST['numTel']."', '".$_POST['heureGMT']."', '".$_POST['villeAeroport'].";";
        try {
            echo $sql;
            //$conn->exec($sql);
            echo "Ajout à la base de données réussie.";
        }
        catch (PDOException $e) {
            die("Ajout impossible : " . $e->getMessage());
        }
    }

    ?>



    <?php include "Menu.php" ?>
<footer class="bottom">
    <?php include("Footer.php") ?>
</footer>

</body>
</html>
