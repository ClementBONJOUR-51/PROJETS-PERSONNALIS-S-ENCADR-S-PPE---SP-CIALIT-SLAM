<?php
/**
 * Vue Liste des frais au forfait
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<div class="row">    
    <h2>
    <?php if(!$_SESSION['comptableBool']){?>Renseigner ma fiche de frais du mois <?php }?>
    <?php echo $numMois . '-' . $numAnnee ?>
    </h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
    <?php if(!$_SESSION['comptableBool']){ ?>
        <form method="post" 
              action="index.php?uc=gererFrais&action=validerMajFraisForfait" 
              role="form">
    <?php }else{?>
    	<form method="post" 
              action="index.php?uc=validerFrais&action=corrigerFraisForfait" 
              role="form">
    <?php }?>
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    
                <?php } ?>
                <div class="form-group" style="visibility: hidden;"> <!-- idVisiteur et mois qu'on r�envoi -->
                        <input type="text" id="leVisiteur" 
                               name="leVisiteur"
                               value="<?php echo $idVisiteurChoisi ?>">
                        <input type="text" id="leMois" 
                               name="leMois"
                               value="<?php echo $leMois ?>">
                </div>    
                               
                <?php if(!$_SESSION['comptableBool']){?>
                <button class="btn btn-success" type="submit">Ajouter</button>
                <?php }else{?>
                <button class="btn btn-success" type="submit">Corriger</button>
                <?php }?>
                <button class="btn btn-danger" type="reset">Effacer</button>
            </fieldset>
        </form>
    </div>
</div>
