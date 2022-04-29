<?php
session_start();
$_email = "";
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
?>