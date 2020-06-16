<?php $title = 'affichage Commentaires'; ?>

<div class="row-md-3">
   <div class="col-md-3">
      <div align="center"><a href="index.php">Retour accueil</a></div>
      <div class="card mb-3 shadow-sm">
         <svg class="bd-placeholder-img card-img-top" width="100%" height="75" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
            <title>liste articles</title>
            <rect width="100%" height="100%" fill="#55595c"/>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em"><?=($article['title']) ?></text>
         </svg>
         <div align="center"class=" card-body">
            <p class="card-text"> <?= nl2br($article['content']) ?></p>
            <!--Attention le htmlspecialchars absent pour éviter qu'à cause de tiny nous ayons les balises html à l'affichage merci de votre compréhention... -->
            <div class="d-flex justify-content-between align-items-center">
               <small class="text-muted"><em>le <?= $article['creation_date_fr'] ?></em></small>
            </div>
         </div>
      </div>
   </div>
</div>
<div align="center">
   <br>
   <div class="encart" >
   <br/>
   <?php if(isset($_SESSION['id'])) : ?> 
      <h2>Mon commentaire :</h2>
      <form action="index.php?action=addComment&amp;id=<?=$article['id'] ?>"method="post">
         <div>
            <textarea id="comment" name="content" placeholder="Votre texte"></textarea>
         </div>
         <div><br>
            <button type="submit"class="btn btn-secondary">J'envoie mon commentaire !</button><br>
         </div>
      </form>
      <?php else :
         echo '<h3 class="error">Pour l\'ajout d\'un commentaire, veuillez vous connecter !</h3>
         <p><a href="index.php?action=displFormulContact">Pas encore insrit ?</a></p>
         <p><a href="index.php?action=displConnexion">Connexion ?</a></p';
         endif ?>
      <div>
         <br>
         <h2>Vos commentaires :</h2>
         <?php
            while ($comment = $comments->fetch()): ?> 
         <!--affiche l'auteur la date et le commentaire-->
         <div >
            <br>
            <p><em>Envoyé le : </em><?= $comment['comment_date_fr'] ?></p>
            <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            <p><em>De la part de : </em><?= $comment['pseudo'] ?></p>
           
            <?php endwhile;
               $comments->closeCursor(); 
               ?>
         </div>
      </div>
   </div>
</div>











































         
        