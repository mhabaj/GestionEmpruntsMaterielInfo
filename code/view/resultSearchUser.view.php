<a href="DetailUser.php?id_user_toDisplay=<?php if(isset($donnees['id_user']) && $donnees['id_user']!= null) echo $donnees['id_user'] ?>">
    <div class="panel panel-success">
        <div class="panel-heading"><?php if(isset($donnees['matricule_user']) && $donnees['matricule_user']!= null) echo $donnees['matricule_user']; ?></div>
        <div class="panel-body">
        <strong> Matricule </strong> : <?php if(isset($donnees['matricule_user']) && $donnees['matricule_user']!= null) echo $donnees['matricule_user']; ?> <br/>
        <strong> Firstname </strong> : <?php if(isset($donnees['name_user']) && $donnees['name_user']!= null) echo $donnees['name_user']; ?> <br/>
        <strong> Lastname </strong> : <?php if(isset($donnees['lastname_user']) && $donnees['lastname_user']!= null) echo $donnees['lastname_user']; ?> <br/>
        <strong> email </strong> : <?php if(isset($donnees['email_user']) && $donnees['email_user']!= null) echo $donnees['email_user']; ?> <br/> <br/>
        </div>
   </div>
</a>