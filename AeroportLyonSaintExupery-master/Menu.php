
<div class="lediv">

    <menu>
        <ul>
            <?php
            session_start();
            $xmlMenu = simplexml_load_file("menu.xml") or die ();
            foreach($xmlMenu->liens->children() as $lien)
            {
                echo "<li> <a href=".$lien->link.">".$lien->nomFR."</a></li>";
            }
            ?>
        </ul>
    </menu>

    <article>
        Contenu
    </article>

</div>