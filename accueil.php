 <?php
    include("header.php");

    $requeteBillet = "SELECT * FROM billets, utilisateurs WHERE billets.id_user = utilisateurs.id ORDER BY billets.id_billet DESC LIMIT 3";
    $stmt = $db->query($requeteBillet);
    $resultRequetBillet = $stmt->fetchall(PDO::FETCH_ASSOC);

    ?>

 <div class="header">
     <h1 class="titre">🚢 Voyage-Voyage 🚢</h1>
     <h2><?php if (isset($_SESSION["pseudo"])) {

                echo "Bonjour {$_SESSION["pseudo"]}, ";
            } ?>
         bienvenu à toi sur Voyage-Voyage, un blog géré par Yannick</h2>
 </div>
 <?php if (isset($_SESSION["pseudo"])) {
        echo "<a href='deconnexion.php'>Se déconnecter</a>";
    } ?>


 <div class="billet-list">
     <h3>Liste de tous les billets :</h3>
     <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            echo "<a href='add-billet.php'>Ajouter un nouveau billet</a>";
        } ?>
     <div class="billet-container">
         <?php foreach ($resultRequetBillet as $billet) {
            ?>
             <div class="billet">
                 <a href="billet.php?id=<?php echo $billet["id_billet"] ?>" class="billet-link">

                     <div class="billet-header">
                         <h3><?php echo $billet["titre"] ?></h3>
                     </div>

                     <div class="billet-content">
                         <?php
                            $dateObj = new DateTime($billet["date"]);
                            $formattedDate = $dateObj->format('M d, Y');

                            echo "<p>{$billet["pseudo"]} - {$formattedDate}</p>";
                            ?>
                     </div>
                     <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"] = 1) { ?>
                         <div class="billet-admin">
                             <a href="traiteBillet.php?requete=delete&idBillet=<?php echo $billet["id_billet"] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce billet?')">Supprimer le billet</a>
                             <a href="modif-billet.php?idBillet=<?php echo $billet["id_billet"] ?>">Modifier le billet</a>
                         </div>
                     <?php }; ?>
                 </a>
             </div>
         <?php } ?>
     </div>
 </div>

 <?php include("footer.php"); ?>