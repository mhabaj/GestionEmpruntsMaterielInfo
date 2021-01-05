<html lang="fr">
<body>
<form method="POST" enctype="multipart/form-data">
    <label><b>Veuillez entrer un nouveau mot de passe</b></label>
    <input type="password" placeholder="Veuillez entrer un mot de passe" name="password" >
    <br><br>
    <label><b>Retapez le mot de passe</b></label>
    <input type="password" placeholder="Répéter le mot de passe" name="passwordrepeat" required>
    <br><br>
    <button type="button" name="cancelMdp">Annuler les modifications</button>
    <button type="submit" name="submitModificationMdp">Confirmer les modifications </button>
</form>
</body>
</html>