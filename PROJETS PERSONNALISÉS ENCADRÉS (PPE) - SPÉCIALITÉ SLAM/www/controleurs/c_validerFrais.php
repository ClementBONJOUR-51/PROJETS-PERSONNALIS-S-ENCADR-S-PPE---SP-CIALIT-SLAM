<?php 
/**
 * VALIDATION D’UNE FICHE DE FRAIS
 */



$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case 'selectionnerVisiteur':
    $lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
    //var_dump($lesVisiteurs);
    //var_dump($lesVisiteurs[0]['id']);
    $VisiteurSelectionner = $lesVisiteurs[0]; //selection par defaut
    include 'vues/v_listeVisiteur.php';
    break;
case 'selectionnerMois':
    $lesMois = $pdo->getLesMoisDisponibles($VisiteurSelectionner);
    $lesClesMois = array_keys($lesMois);
    $moisASelectionner = $lesClesMois[0];
    include 'vues/v_listeMois.php';
    break;
}
?>
