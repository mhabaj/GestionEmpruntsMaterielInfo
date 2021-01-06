
<div class="row">
    <article class="col-sm-8 maincontent">
<a href="DetailEquipment.php?ref_equip=<?php if(isset($donnees['ref_equip']) && $donnees['ref_equip']!= null) echo $donnees['ref_equip'] ?>">
    <div>
        <strong> Type </strong> : <?php if(isset($donnees['type_equip']) && $donnees['type_equip']!= null) echo $donnees['type_equip']; ?> <br/>
        <strong> Nom </strong> : <?php if(isset($donnees['name_equip']) && $donnees['name_equip']!= null) echo $donnees['name_equip']; ?> <br/>
        <strong> Matériel </strong> : <?php if(isset($donnees['brand_equip']) && $donnees['brand_equip']!= null) echo $donnees['brand_equip']; ?>
        <br/>
        <strong> Version </strong> : <?php if(isset($donnees['version_equip']) && $donnees['version_equip']!= null) echo $donnees['version_equip']; ?> <br/> <br/>
    </div>
</a>
    </article>
</div>