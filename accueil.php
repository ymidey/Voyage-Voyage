 <?php
    include("header.php");
    $resultRequetBillet = getDerniersBillets(3);
    ?>

 <div class="header">
     <h1 class="titre">🚢 Voyage-Voyage 🚢</h1>
     <h2><?php if (isset($_SESSION["pseudo"])) {

                echo "Bonjour {$_SESSION["pseudo"]}, ";
            } ?>
         bienvenue à toi sur Voyage-Voyage, un blog géré par Yannick Midey</h2>
 </div>

 <div class="billet-list">
     <h3>Les 3 derniers billets postés sur le blog :</h3>
     <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            echo "<a href='add-billet.php' style='color:darkblue'>Ajouter un nouveau billet</a>";
        } ?>
     <div class="billet-container">
         <?php foreach ($resultRequetBillet as $billet) {
            ?>
             <div class="billet billet-hover">
                 <a href="billet.php?id_billet=<?php echo $billet["id_billet"] ?>" class="billet-link">

                     <div class="billet-header">
                         <?php echo "<h4>" . $billet["titre"] . "</h4>" ?>
                         <?php
                            $dateObj = new DateTime($billet["date"]);
                            $formattedDate = $dateObj->format('d M, Y');

                            echo "<p>Publié le {$formattedDate} par {$billet["pseudo"]}</p>";
                            ?>
                     </div>

                     <div class="billet-content">
                         <?php
                            $contenuBillet = $billet["contenu"];

                            if (strlen($contenuBillet) > 100) {
                                $contenuTronque = substr($contenuBillet, 0, 100) . '...';
                                echo "<p>" . $contenuTronque . "</p>";
                            } else {
                                echo "<p>" . $contenuBillet . "</p>";
                            }
                            ?>
                     </div>
                     <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) { ?>
                 </a>
                 <div class="billet-admin">
                     <a href="traitebillet.php?requete=delete&idBillet=<?php echo $billet["id_billet"] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce billet?')">Supprimer le billet</a>
                     <a href="modif-billet.php?idBillet=<?php echo $billet["id_billet"] ?>">Modifier le billet</a>
                 </div>
             <?php }; ?>
             </a>
             </div>
         <?php } ?>
     </div>
     <a href="archive.php" class="link-button">Acceder à tout les billets</a>
 </div>

 <?php include("footer.php"); ?>