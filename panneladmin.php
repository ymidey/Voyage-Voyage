 <?php
    include("header.php");

    $requeteShowUtillisateurs = "SELECT * FROM utilisateurs";
    $stmt = $db->query($requeteShowUtillisateurs);
    $resultShowUtilisateurs = $stmt->fetchall(PDO::FETCH_ASSOC);

    ?>

 <h1>Pannel admin</h1>
 <table>
     <thead>
         <tr id="header">
             <th>Login</th>

             <th>Pseudo</th>
             <th>Supprimer</th>
         </tr>
     </thead>
     <tbody>
         <?php foreach ($resultShowUtilisateurs as $showUtilisateurs) : ?>
             <tr>
                 <td data-title="login"><?php echo $showUtilisateurs["login"] ?></td>
                 <td data-title="login"><?php echo $showUtilisateurs["pseudo"] ?> </td>

                 <td data-title="Supprimer"><a href="traiteadmin.php?delete=<?php echo $showUtilisateurs["id"] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette utilisateur')">Supprimer</a>
                 </td>
             </tr>
         <?php endforeach; ?>
     </tbody>
 </table>