<?php
/**
 * Vue Suivre les payement des fiches de frais
 * 
 * permet d'avoir la liste des fiche de frais validÈes
 */
?>
<div class="row">

<?php foreach ($listeInfoFicheFrais as $infoFicheFrais){?>
    <div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
                    <?php echo $infoFicheFrais['visiteur']['nom'] ?>
                    <?php echo $infoFicheFrais['visiteur']['prenom'] ?>
                     - 
                    <?php echo $infoFicheFrais['mois']['numMois'] ?>/<?php echo $infoFicheFrais['mois']['numAnnee'] ?>
                    (<?php echo $infoFicheFrais['infoFiche']['libEtat']?>)
                </h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th class="date">Forfaits</th>
								<th class="libelle">Hors forfait</th>
								<th class="montant">Total</th>
								<th class="action">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<form method="post"
								action="index.php?uc=suivreFrais&action=changementEtat"
								role="form">
								<input type="text" id="leVisiteur" name="leVisiteur"
									value="<?php echo $infoFicheFrais['visiteur']['id'] ?>"
									style="display: none"> <input type="text" id="leMois"
									name="leMois"
									value="<?php echo $infoFicheFrais['mois']['mois'] ?>"
									style="display: none">
								<tr>
									<td><?php echo $infoFicheFrais['totalForfait'] ?> 	&euro;</td>
									<td><?php echo $infoFicheFrais['totalHorsForfait'] ?> 	&euro;</td>
									<td><?php echo ($infoFicheFrais['totalForfait'] + $infoFicheFrais['totalHorsForfait']) ?> 	&euro;</td>
								<?php if($infoFicheFrais['infoFiche']['idEtat']=="VA"){?>
								<td>
										<button class="btn btn-success" type="submit"
											onclick="confirm('Voulez-vous vraiment mettre en paiement cette fiche de frais ?');">
											Mettre en paiement</button>
									</td>
        						<?php }else if($infoFicheFrais['infoFiche']['idEtat']=="MP"){?>
								<td>
										<button class="btn btn-success" type="submit"
											onclick="confirm('Cette fiche de frais est-elle vraiment remboursÈe ?');">
											est Rembours√©e</button>
									</td>
        						<?php }?>
							</tr>
							</form>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php }?>

</div>
