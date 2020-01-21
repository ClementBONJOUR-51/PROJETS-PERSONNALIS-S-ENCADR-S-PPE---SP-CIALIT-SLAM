<?php
/**
 * Vue Liste des frais hors forfait
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
if($lesFraisHorsForfait!=null && count($lesFraisHorsForfait)>0){
?>
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th>
                    <th class="action">&nbsp;</th> 
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                <?php if(!$_SESSION['comptableBool']){?>
                    <td> <?php echo $date ?></td>
                    <td> <?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                    <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                <?php }else{?>
                <form id="formCorrFraisHF[<?php echo $id ?>]" method="post" action="index.php?uc=validerFrais&action=corrigerFraisHorsForfait" role="form">
                	<input type="text" id="idFraisHF" name="idFraisHF" value="<?php echo $id ?>" style="display:none">
                	<input type="text" id="leVisiteur" name="leVisiteur"value="<?php echo $idVisiteurChoisi ?>" style="display:none">
                    <input type="text" id="leMois" name="leMois" value="<?php echo $moisSelectionner ?>" style="display:none">
                	<td><input type="text" id="dateHF[<?php echo $id ?>]" name="dateHF" value="<?php echo $date ?>"
                				onchange="	document.getElementById('corrFraisHF[<?php echo $id ?>]').disabled = false;
                							document.getElementById('validerFicheFrais').disabled = true"></td>
                	<td><input type="text" id="libHF[<?php echo $id ?>]" name="libHF" value="<?php echo $libelle ?>"
                				onchange="	document.getElementById('corrFraisHF[<?php echo $id ?>]').disabled = false;
											document.getElementById('validerFicheFrais').disabled = true"></td>
                	<td><input type="text" id="montantHF[<?php echo $id ?>]" name="montantHF" value="<?php echo $montant ?>"
                				onchange="	document.getElementById('corrFraisHF[<?php echo $id ?>]').disabled = false;
                							document.getElementById('validerFicheFrais').disabled = true"></td>
                	<td><button id="corrFraisHF[<?php echo $id?>]" class="btn btn-success" type="submit" disabled
                 				onclick="alert('Les informations de frais ont bien été corrigées');">Corriger</button></td>
                 	<td><button class="btn btn-danger" type="submit" 
                 				onclick="
                 				confirm('Voulez-vous vraiment refuser le frais intitulé : &quot;<?php echo $libelle ?>&quot; ?');
                 				getElementById('libHF[<?php echo $id ?>]').value = 'REFUSE : '+getElementById('libHF[<?php echo $id ?>]').value;"
                 <?php if(substr($libelle,0,8)=="REFUSE :"){ ?>disabled <?php }?>
                 >REFUSER</button></td>
                 <td><button class="btn btn-warning" type="submit"
                 				onclick="document.getElementById('formCorrFraisHF[<?php echo $id?>]').action = 'index.php?uc=validerFrais&action=reporterFraisHorsForfait'; confirm('Voulez-vous vraiment reporter ce frais au mois prochain ?');">
                 	Reporter</button></td>
                </form >
                <?php } ?>
                </tr>
                <?php } ?>
            </tbody>  
        </table>
    </div>
</div>
<?php if(!$_SESSION['comptableBool']){?>
<div class="row">
    <h3>Nouvel élément hors forfait</h3>
    <div class="col-md-4">
        <form action="index.php?uc=gererFrais&action=validerCreationFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                <input type="text" id="txtDateHF" name="dateFrais" 
                       class="form-control" id="text">
            </div>
            <div class="form-group">
                <label for="txtLibelleHF">Libellé</label>             
                <input type="text" id="txtLibelleHF" name="libelle" 
                       class="form-control" id="text">
            </div> 
            <div class="form-group">
                <label for="txtMontantHF">Montant : </label>
                <div class="input-group">
                    <span class="input-group-addon">€</span>
                    <input type="text" id="txtMontantHF" name="montant" 
                           class="form-control" value="">
                </div>
            </div>
            <button class="btn btn-success" type="submit">Ajouter</button>
            <button class="btn btn-danger" type="reset">Effacer</button>
        </form>
    </div>
</div>
<?php }

}else{?><h2>Aucun frais Hors forfait pour ce visiteur</h2><?php }?>