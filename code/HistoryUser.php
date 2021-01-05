<?php
require_once("Controller/control-session.php");
require_once("Controller/UserController.php");
require_once("ControllerDAO/UserDAO.php");

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1  && isset($_GET['id_user_toDisplay']) || $_GET['id_user_toDisplay'] == $_SESSION['id_user'] && isset($_GET['id_user_toDisplay'])) {
    if(!UserDAO::userExists($_GET['id_user_toDisplay']))
        header('Location: DashBoard.php');

    try
    {
        $finalStatement = UserDAO::getHistory($_GET['id_user_toDisplay']);
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    ?>

    <?php
    //On include view ici
    require_once("View/historyUser.view.php");
    ?>

    <?php
}
else{
    ?>
    <label>Erreur veuillez contacter le support</label>
    <?php
}
?>

</body>
</html>