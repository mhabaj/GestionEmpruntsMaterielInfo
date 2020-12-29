


<?php
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {
    ?>


    <meta charset="utf-8">
    <meta name="viewport"    content="width=device-width, initial-scale=1.0">

    <title>Gestion d'emprunt de matériel informatique</title>

    <link rel="shortcut icon" href="assets/images/gt_favicon.png">

    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
    <link rel="stylesheet" href="assets/css/Overview.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <h3>Espace Administrateur</h3>
    <div class="form row">
        <form method="POST" enctype="multipart/form-data">
            <button id="btnAddEquipment" class="btn btn-primary" type="submit" name="addEquip">Ajouter un nouvel Equipement</button>
        </form>
    </div>
    <br><br>
    <div id="searchUserRow" class="form-row">
        <form method="POST" enctype="multipart/form-data">
            <label>Rechercher utilisateur:</label>
            <input type="search" placeholder="Matricule de l'utilisateur" name="UserToSearch">
            <button type="submit" name="startSearchingUser">Rechercher</button>
        </form>
    </div>

    <?php
}