<?php


         
            while ($comment = $comments->fetch()): ?> 
         <!--affiche l'auteur la date et le commentaire-->
         <div >
            <br>
            <p><em>Envoyé le : </em><?= $comment['comment_date_fr'] ?></p>
            <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            <p><em>De la part de : </em><?= $comment['pseudo'] ?></p>
            
        
        </div>
        <?php endwhile;
        $comments->closeCursor(); 
        ?>
        
