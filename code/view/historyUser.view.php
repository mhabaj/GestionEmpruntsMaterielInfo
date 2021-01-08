<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once("head.view.php");
require_once("navbar.view.php");
?>
<!-- Intro -->
<div class="container">
    <div class="maincontent">
        <br> <br>
        <h2 class="thin"></h2>
        <p class="text-muted">

        </p>
        <!-- /Intro-->


<div class="panel panel-primary">
    <?php if (isset($erreur) && !$erreur == "") echo "<p>" . $erreur . "</p>"; ?>
    <div class="panel-heading">emprunt n°<?php if (isset($donnees)) echo $donnees['id_borrow']; ?></div>
    <div class="panel-body">
    <strong> Emprunt numéro </strong> : <?php if (isset($donnees)) echo $donnees['id_borrow']; ?> <br/>
    <strong> Nom du matériel emprunté</strong> : <?php if (isset($donnees)) echo $donnees['name_equip']; ?>
    <br/>
    <strong> Id du matériel emprunté </strong> : <?php if (isset($donnees)) echo $donnees['id_device']; ?>
    <br/>
    <strong> Date début emprunt </strong> : <?php if (isset($donnees)) echo $donnees['startdate_borrow']; ?>
    <br/>
    <strong> Date fin emprunt </strong> : <?php if (isset($donnees)) echo $donnees['enddate_borrow']; ?>
    </div>
</div>
</div>
</div>


