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
if( $lesFraisForfait!=null && count($lesFraisForfait)>0){
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
              role="form"
              onchange="document.getElementById('corrFraisF').disabled = false;
                        document.getElementById('majFraisF').disabled = false;">
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
                <div class="form-group" style="display: none;"> <!-- idVisiteur et mois qu'on r�envoi -->
                        <input type="text" id="leVisiteur" 
                               name="leVisiteur"
                               value="<?php echo $idVisiteurChoisi ?>">
                        <input type="text" id="leMois" 
                               name="leMois"
                               value="<?php echo $leMois ?>">
                </div>    
                               
                <?php if(!$_SESSION['comptableBool']){?>
                <button id="majFraisF" class="btn btn-success" type="submit" disabled>Mettre &agrave; jour</button>
                <?php }else{?>
                <button id="corrFraisF" class="btn btn-success" type="submit" disabled
                 onclick="alert('Les informations de frais ont bien été corrigées');">Corriger</button>
                <?php }?>
                <button class="btn btn-danger" type="reset"
                 onclick="alert('Actualisation des informations, les changements seront perdus');document.getElementById('corrFraisF').disabled = true;document.getElementById('corrFraisF').disabled = true;
                     ">Réinitialiser</button>
            </fieldset>
        </form>
    </div>
</div>
<?php }else{?><h2>Aucun frais forfait pour ce visiteur</h2><?php }?>
