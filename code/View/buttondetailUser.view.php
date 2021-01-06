<html>
<body>

<form method="get" action="DetailUser.php">
    <button type="submit"
            value="<?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != "") echo $_SESSION['id_user'] ?>"
            name="id_user_toDisplay">Mon compte
    </button>
</form>