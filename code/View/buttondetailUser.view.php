
<html>
<body>

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
        <div class="navbar-header">
            <!-- Button for smallest screens -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" alt="logo"></a>
        </div>
    </div>
</div>
<!-- /.navbar -->

<form method="get" action="DetailUser.php">
    <button id="btnDetails" class="btn btn-primary" type="submit"  value="<?php echo $_SESSION['id_user'] ?>" name="id_user_toDisplay">Mon compte</button>
</form>