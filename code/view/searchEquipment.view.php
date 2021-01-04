

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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->


<div class="header" id="CatalogueHeader">
    <h1>Catalogue</h1>
    <p>Catalogue des équipements</p>
</div>
<br><br>

<form id="searchEquipmentForm" method="POST" enctype="multipart/form-data">
    <label>Rechercher équipement</label>
        <div class="form row">
            <input type="search" placeholder="Inserer l'équipement" name="EquipmentToSearch">
            <input type="radio" name="radio_recherche" id="radio_name" value="radio_name" checked>
            <label for="radio_name">par nom</label>
            <input type="radio" name="radio_recherche" id="radio_ref" value="radio_ref">
            <label for="radio_ref">par référence</label>
            <button type="submit" class="btn btn-primary" name="startSearching">Rechercher</button>
        </div>
</form>


