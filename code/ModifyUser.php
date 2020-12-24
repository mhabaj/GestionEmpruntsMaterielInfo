<?php

require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Model/UserRegular.php");
require_once("Model/UserAdmin.php");

if(isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1)
{
    if(isset($_GET['id_user_toDisplay']))
    {
        $currentUser = new UserRegular();
        $currentUser->loadingUser($_GET['id_user_toDisplay']);

        ?>
        <html lang="fr">
            <body>
                <form method="POST" enctype="multipart/form-data">
                    <h1>Modifier un utilisateur</h1>
                    <p>Veuillez remplir les champs ci-dessous pour modifier un utilisateur</p>
                    <hr>

                    <label><b>Nom d'utilisateur</b></label>
                    <input type="text" value="<?php echo $currentUser->getMatriculeUser() ?>" name="matricule" >
                    <br><br>
                    <label><b>Mot de passe</b></label>
                    <input type="password" placeholder="Entrer le nouveau mot de passe" name="password" >

                    <label><b>Email</b></label>
                    <input type="email" value="<?php echo $currentUser->getEmail() ?>" name="email" >
                    <br><br>
                    <label><b>Nom de famille</b></label>
                    <input type="text" value="<?php echo $currentUser->getLastName() ?>" name="lastname" >

                    <label><b>Prénom</b></label>
                    <input type="text" value="<?php echo $currentUser->getName() ?>" name="name" >
                    <br><br>
                    <label><b>Numéro de téléphone</b></label>
                    <input type="tel" pattern="[0-9]{10}" value="<?php echo $currentUser->getPhone() ?>" name="phone" >
                    <br><br>
                    <label><b>Modifer les droits de l'utilisateur</b></label>
                    <label>
                        <input type="checkbox" checked="checked" name="administrateur"  value ="ok" style="margin-bottom:15px">Administrateur
                    </label>

                    <hr>
                    <button type="button" name="cancelbtn">Annuler les modifications</button>
                    <button type="submit" name="submitModification">Confirmer les modifications </button>

                </form>
            </body>
        </html>
    <?php
        try
        {
            if (isset($_POST['submitModification']))
            {
                    $matricule = $_POST['matricule'];
                    $email = $_POST['email'];
                    $lastname = $_POST['lastname'];
                    $name = $_POST['name'];
                    $phone = $_POST['phone'];

                    $isAdmin = 0;
                    if(isset($_POST['administrateur']))
                    {
                        $isAdmin = $_POST['administrateur'];
                        if ($isAdmin == 'ok')
                        {
                            $isAdmin = 1;
                        }
                    }
                $currentUserAdmin = new UserAdmin();
                $currentUserAdmin->loadUser();
                $currentUserAdmin->modifyAnyProfile($_GET['id_user_toDisplay'],$matricule,$email,$name, $lastname,$phone,$isAdmin);
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if(isset($_POST['cancelbtn']))
        {
            header('Location: Catalogue');
        }
    }
}
else
    echo "Vous n'avez pas accès à cette page"
?>