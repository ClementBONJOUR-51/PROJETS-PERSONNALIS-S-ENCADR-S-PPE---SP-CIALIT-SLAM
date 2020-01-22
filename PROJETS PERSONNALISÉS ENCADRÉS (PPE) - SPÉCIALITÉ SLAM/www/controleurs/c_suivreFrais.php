<?php 
/**
 * Suivre les fiche de frais
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

$listeInfoFicheFrais = array();
$lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
$montantFrais = $pdo->getLesMontantFrais(); // je prend le montant de tout les Frais existant
foreach ($lesVisiteurs as $leVisiteur){
    $lesMois = $pdo->getLesMoisDisponibles($leVisiteur['id']);
    foreach ($lesMois as $leMois){
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur['id'], $leMois['mois']);
        if($lesInfosFicheFrais['idEtat']=="VA" || $lesInfosFicheFrais['idEtat']=="MP"){
            $infoForfait = $pdo->getLesFraisForfait($leVisiteur['id'],$leMois['mois']);
            $infoHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur['id'],$leMois['mois']);
            $totalForfait = 0;
            $totalHorsForfait = 0;
            //var_dump($infoForfait);
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


switch ($action) {
case 'listeFiche':
    
    //var_dump($listeInfoFicheFrais);
    include 'vues/v_suivreFrais.php';
    break;
case 'changementEtat' :
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $etatInit = $pdo->getLesInfosFicheFrais($idVisiteurChoisi,$leMois)['idEtat'];
//     var_dump($idVisiteurChoisi);
//     var_dump($leMois);
//     var_dump($etatInit);
    
    if($etatInit=='VA'){
        $pdo->majEtatFicheFrais($idVisiteurChoisi, $leMois, 'MP');
    } else if($etatInit=='MP'){
        $pdo->majEtatFicheFrais($idVisiteurChoisi, $leMois, 'RB');
    }
    include 'vues/v_suivreFrais.php';
    break;
}


?>