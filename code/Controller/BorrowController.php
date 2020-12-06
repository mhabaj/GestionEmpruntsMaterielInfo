<?php

class BorrowController
{
    //créer code qui compte le nombre de devices disponibles de la ref rentrée
    //verifier date enddtae > start date


}

?>

<html>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <h1>Réservation</h1>

            <label><b>Date de fin</b></label>
            <input type="text" placeholder="AAAA-MM-JJ" name="endDate" required>

            <label><b>Quantité</b></label>
            <input type="number" min="1" value="1" placeholder="Quantité" name="quantity" required>

            <button type="submit" name="startBorrow">Réserver</button>
        </form>
    </body>
</html>











