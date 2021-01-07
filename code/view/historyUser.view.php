<html>
<body>
<?php if (isset($erreur) && !$erreur == "") echo "<p>" . $erreur . "</p>"; ?>

<div>
    <strong> Emprunt numéro </strong> : <?php if (isset($donnees)) echo $donnees['id_borrow']; ?> <br/>
    <strong> Nom du matériel emprunté</strong> : <?php if (isset($donnees)) echo $donnees['name_equip']; ?>
    <br/>
    <strong> Id du matériel emprunté </strong> : <?php if (isset($donnees)) echo $donnees['id_device']; ?>
    <br/>
    <strong> Date début emprunt </strong> : <?php if (isset($donnees)) echo $donnees['startdate_borrow']; ?>
    <br/>
    <strong> Date fin emprunt </strong> : <?php if (isset($donnees)) echo $donnees['enddate_borrow']; ?>
    <br/>
    <br/>

</div>


</body>
</html>
