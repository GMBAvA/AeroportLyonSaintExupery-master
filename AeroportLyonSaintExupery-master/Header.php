<h1>Bienvenue sur le site non-officiel de l'aéroport de Lyon Saint Exupéry</h1>
<div>
<?php
if(isset($_SESSION['nom']) && isset($_SESSION['prenom']))
{
    echo "<p>"." Bonjour ". $_SESSION['prenom'] ." ". $_SESSION['nom'].  "</p>";
}
?>
</div>
