<?php 
/**
 * Suivre les fiche de frais
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);


switch ($action) {
case 'listeFiche':
    $listeInfoFicheFrais = array();
    $lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
    $montantFrais = $pdo->getLesMontantFrais(); // je prend le montant de tout les Frais existant
    foreach ($lesVisiteurs as $leVisiteur){
        $lesMois = $pdo->getLesMoisDisponibles($leVisiteur['id']);
        foreach ($lesMois as $leMois){
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur['id'], $leMois['mois']);
            if($lesInfosFicheFrais['idEtat']=="VA"){
                $infoForfait = $pdo->getLesFraisForfait($leVisiteur['id'],$leMois['mois']);
                $infoHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur['id'],$leMois['mois']);
                $totalForfait = 0;
                $totalHorsForfait = 0;
                var_dump($infoForfait);
                foreach ($infoForfait as $fraisForfait){ // je lie la quantité avec le montant pour les frais forfait
                    foreach ($montantFrais as $unMontantFrais){
                        if($fraisForfait['idfrais']==$unMontantFrais['idfrais']){
                            $totalForfait = $totalForfait + ($fraisForfait['quantite']*$unMontantFrais['montantfrais']);
                        }
                    }
                }
                foreach ($infoHorsForfait as $fraisHorsForfait){ // je parcours et additionne les frais hors forfait 
                    $totalHorsForfait = $totalHorsForfait + $fraisHorsForfait['montant'];
                }
            array_push($listeInfoFicheFrais,
                array(
                    'visiteur'=>$leVisiteur,
                    'mois'=>$leMois,
                    'infoFiche'=>$lesInfosFicheFrais,
                    'totalForfait'=>$totalForfait,
                    'totalHorsForfait'=>$totalHorsForfait
                ));
            }
        }
    }
    var_dump($listeInfoFicheFrais);
    include 'vues/v_suivreFrais.php';
    break;
}


?>