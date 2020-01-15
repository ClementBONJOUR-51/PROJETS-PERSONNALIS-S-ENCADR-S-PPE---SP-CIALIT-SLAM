<?php 
/**
 * Vue Formulaire Visiteur
 */
?>
<div class="row">
    <div class="col-md-4">
        <form action="index.php?uc=validerFrais&action=resultatFicheFrais" id="formVisiteur"
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur" class="form-control" onchange="this.form.submit()">
                   	<?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $idVisiteur = $unVisiteur['id'];
                        $nomVisiteur = $unVisiteur['nom'];
                        $prenomVisiteur = $unVisiteur['prenom'];
                        if ($unVisiteur == $visiteurSelectionner) {
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
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control" onchange="this.form.submit()">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisSelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
          <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
           <!-- <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
                   -->
        </form>
    </div>
</div>