<?php

require_once("Controller/control-session.php");
require_once("Model/UserAdmin.php");

class EquipmentCreationController
{


    public function create(){
        $currentUser = new UserAdmin();
        $currentUser->loadUser();
        $currentUser->createEquipment($this->ref, $this->type, $this->brand, $this->name, $this->version, $this->quantity);
    }




}

$ecc = null;

if (!isset($_GET['submitEquipment'])) {
    $ecc = new EquipmentCreationController("", "", "", "", "", 1);
}
else {
    $ecc = new EquipmentCreationController($_GET["ref"], $_GET["type"], $_GET["brand"], $_GET["name"], $_GET["version"], $_GET["quantity"]);
}

?>
    <html>
    <body>
    <form method="GET" action="PageCreationMateriel.php" enctype="multipart/form-data">
        <h1>Création matériel</h1>

        <label><b>Référence</b></label>
        <input type="text" placeholder="Référence matériel" name="ref" value="<?php echo $ecc->getRef();?>" required>

        <br/><label><b>Type</b></label>
        <input type="text" placeholder="Type matériel" name="type" value="<?php echo $ecc->getType();?>" required>

        <br/><label><b>Marque</b></label>
        <input type="text" placeholder="Marque matériel" name="brand" value="<?php echo $ecc->getBrand();?>" required>

        <br/><label><b>Nom</b></label>
        <input type="text" placeholder="Nom matériel" name="name" value="<?php echo $ecc->getName();?>" required>

        <br/><label><b>Version</b></label>
        <input type="text" placeholder="Version matériel" name="version" value="<?php echo $ecc->getVersion();?>" required>

        <br/><label><b>Quantité</b></label>
        <input type="number" placeholder="Quantité matériel" name="quantity" value="<?php echo $ecc->getQuantity();?>" required>

        <br/><button type="submit" name="submitEquipment">Création</button>
    </form>
    </body>
    </html>

<?php

if (isset($_GET['submitEquipment'])) {

    //if (!isset($_SESSION['id_user'])) {
    $ecc->setRef($_GET['ref']);
    $ecc->setType($_GET['type']);
    $ecc->setBrand($_GET['brand']);
    $ecc->setName($_GET['name']);
    $ecc->setVersion($_GET['version']);
    $ecc->setQuantity($_GET['quantity']);

    if (strlen($ecc->getRef()) == 5) {
        if (!$ecc->isRefEquipValid()){
            if ($ecc->getQuantity() > 0) {
                $ecc->create();
            }
        }
    }
    else{

    }

    //} else {
    //    header('Location: Catalogue.php');
    //}
}

?>