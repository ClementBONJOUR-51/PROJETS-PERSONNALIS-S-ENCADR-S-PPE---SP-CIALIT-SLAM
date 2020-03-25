<?php

/**
 * Vue Validation Fiche Frais
 * 
 * permet � l'utilisateur de valid� la fiche de frais 
 */
?>

<div class="row">
	<?php
	if (isset($lesInfosFicheFrais['idEtat'])) {
		if ($lesInfosFicheFrais['idEtat'] != 'VA') { ?>
			<h3>Veuillez vérifier si toutes les corrections voulues ont été apportés avant de valider</h3>
			<form method="post" action="index.php?uc=validerFrais&action=validerFicheFrais" role="form">

				<fieldset>
					<div class="form-group" style="display: none;">
						<!-- idVisiteur et mois qu'on r�envoi -->
						<input type="text" id="leVisiteur" name="leVisiteur" value="<?php echo $idVisiteurChoisi ?>">
						<input type="text" id="leMois" name="leMois" value="<?php echo $leMois ?>">
					</div>
					<button id="validerFicheFrais" class="btn btn-success" type="submit" onclick="confirm('Voulez-vous vraiment valider cette fiche de frais ?');">
						Valider
					</button>

				</fieldset>
			</form>
		<?php } else { ?>
			<h3>Cette fiche de frais a déja été validée</h3>
	<?php }
	} ?>
</div>