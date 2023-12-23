 <?php
    include("header.php");

    if ($_SESSION['admin'] == 1) {


    $requeteShowUtillisateurs = "SELECT * FROM utilisateurs";
    $stmt = $db->query($requeteShowUtillisateurs);
    $resultShowUtilisateurs = $stmt->fetchall(PDO::FETCH_ASSOC);

    $requeteShowAllComments = "SELECT commentaires.*, utilisateurs.pseudo, billets.titre, billets.id_billet FROM commentaires, utilisateurs, billets WHERE commentaires.id_user = utilisateurs.id && billets.id_billet = commentaires.id_Billets ORDER BY commentaires.date_publication DESC";
    $stmt = $db->query($requeteShowAllComments);
    $resultShowAllComments = $stmt->fetchall(PDO::FETCH_ASSOC);    ?>

 <div class="header">
     <h1 class="titre">🧰 Pannel admin 🧰</h1>
 </div>

 <div class="pannel-content">
     <h2>Liste de tout les utilisateurs inscrit sur le forum : </h2>

     <table>
         <thead>
             <tr id="header">
                 <th>Login</th>
                 <th>Pseudo</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>
             <?php foreach ($resultShowUtilisateurs as $showUtilisateurs) : ?>
             <tr>
                 <td data-title="login"><?php echo $showUtilisateurs["login"] ?></td>
                 <td data-title="pseudo"><?php echo $showUtilisateurs["pseudo"] ?> </td>
                 <td data-title="Supprimer"><a
                         href="traiteadmin.php?requete=deluser&delete=<?php echo $showUtilisateurs["id"] ?>"
                         onclick="return confirm('Voulez-vous vraiment supprimer cette utilisateur')">Supprimer</a>
                 </td>
             </tr>
             <?php endforeach; ?>
         </tbody>
     </table>

     <h2>Liste de tout les commentaires sur le forum : </h2>
     <table>
         <thead>
             <tr id="header">
                 <th>Pseudo</th>
                 <th>Publié sur</th>
                 <th>Contenu</th>
                 <th>Date de publication</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>
             <?php foreach ($resultShowAllComments as $comments) : ?>
             <tr>
                 <td data-title="pseudo"><?php echo $comments["pseudo"] ?></td>
                 <td data-title="billet"><a
                         href="billet.php?id_billet=<?php echo $comments["id_billet"] ?>"><?php echo $comments["titre"] ?></a>
                 </td>
                 <td data-title="contenu"><?php echo $comments["contenu"] ?> </td>
                 <td data-title="datePublication"><?php echo $comments["date_publication"] ?> </td>
                 <td data-title="Supprimer"><a
                         href="traiteadmin.php?requete=delcom&delete=<?php echo $comments["id_commentaire"] ?>"
                         onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire')">Supprimer</a>
                 </td>
             </tr>
             <?php endforeach; ?>
         </tbody>
     </table>
 </div>

 <?php } else {
    header("Location: accueil.php");
}?>