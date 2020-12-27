<?php

if($finalStatement->rowCount() > 0)
{
    while ($donnees = $finalStatement->fetch()) { ?>
        <div>
            <strong> Emprunt numéro </strong> : <?php echo $donnees['id_borrow']; ?> <br/>
            <strong> Id du matériel physique emprunté </strong> : <?php echo $donnees['id_device']; ?> <br/>
            <strong> Date début emprunt </strong> : <?php echo $donnees['startdate_borrow']; ?> <br/>
            <strong> Date fin emprunt </strong> : <?php echo $donnees['enddate_borrow']; ?> <br/>
            <br/>
        </div>
        </a>
        <?php
    }
}
else{
    ?>
    <label>L'utilisateur n'a emprunté aucun objet jusqu'à présent.</label>
    <?php
}