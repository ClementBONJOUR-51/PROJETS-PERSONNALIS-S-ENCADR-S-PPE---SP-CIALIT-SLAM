<?php 
/**
 * Vue Formulaire Visiteur
 */
?>
<div class="row">
    <div class="col-md-4">
        <h3>choisir le visiteur et le mois: </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=voirEtatFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur" class="form-control">
                   	<?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $idVisiteur = $unVisiteur['id'];
                        $nomVisiteur = $unVisiteur['nom'];
                        $prenomVisiteur = $unVisiteur['prenom'];
                        if ($unVisiteur == $VisiteurSelectionner) {
                            ?>
                            <option selected value="<?php echo $idVisiteur ?>">
                                <?php echo $nomVisiteur . ' ' . $prenomVisiteur ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $idVisiteur ?>">
                                <?php echo $nomVisiteur . ' ' . $prenomVisiteur ?> </option>
                            <?php
                        }
                    }
                    ?>  
                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
        </form>
    </div>
</div>