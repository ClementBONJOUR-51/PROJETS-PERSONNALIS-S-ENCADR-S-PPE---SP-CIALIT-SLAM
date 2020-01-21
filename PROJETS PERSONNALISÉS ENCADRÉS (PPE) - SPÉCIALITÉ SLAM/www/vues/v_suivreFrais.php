<?php
/**
 * Vue Suivre les payement des fiches de frais
 * 
 * permet d'avoir la liste des fiche de frais validées
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
                    (<?php echo $infoFicheFrais['info']['libEtat']?>)
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
								<th class="action">&nbsp;</th>
								<th class="action">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php }?>

</div>
