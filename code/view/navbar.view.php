

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
        <div class="navbar-header">
            <!-- Button for smallest screens -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="#"><img src="assets/images/logo.png" alt="logo"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-left">
                <form action="DashBoard.php" enctype="multipart/form-data">
                    <button class="btn btn-success" type="submit">Catalogue</button>
                </form>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li>
                    <form method="get" action="DetailUser.php">
                        <button class="btn btn-success" type="submit"
                                value="<?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != "") echo $_SESSION['id_user'] ?>"
                                name="id_user_toDisplay">Mon compte
                        </button>
                    </form>
                </li>
                <li>
                        <form method="GET" action="Disconnect.php" enctype="multipart/form-data">
                            <button class="btn btn-danger" type="submit" name="disconnect">Deconnexion</button>
                        </form>

                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
    <?php if (isset($erreur) && !$erreur == "") echo "<p>" . $erreur . "</p>"; ?>
</div>
<!-- /.navbar -->

