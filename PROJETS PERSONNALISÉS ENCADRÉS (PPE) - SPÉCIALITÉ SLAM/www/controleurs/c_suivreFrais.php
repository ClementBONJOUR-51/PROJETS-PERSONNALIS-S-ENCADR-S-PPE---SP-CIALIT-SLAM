<?php 
/**
 * Suivre les fiche de frais
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case 'listeFiche':
    $listeInfoFicheFrais = array();
    $lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
    foreach ($lesVisiteurs as $leVisiteur){
        $lesMois = $pdo->getLesMoisDisponibles($leVisiteur['id']);
        foreach ($lesMois as $leMois){
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur['id'], $leMois['mois']);
            if($lesInfosFicheFrais['idEtat']=="VA"){
            array_push($listeInfoFicheFrais,array('visiteur'=>$leVisiteur,'mois'=>$leMois,'info'=>$lesInfosFicheFrais));
            }
        }
    }
    var_dump($listeInfoFicheFrais);
    include 'vues/v_suivreFrais.php';
    break;
}


?>