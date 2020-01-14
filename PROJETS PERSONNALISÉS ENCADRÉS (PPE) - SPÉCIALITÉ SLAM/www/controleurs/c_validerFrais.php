<?php 
/**
 * VALIDATION D’UNE FICHE DE FRAIS
 */



$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case 'selectionnerVisiteur':
    $lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
    console.log($lesVisiteurs);
    $lesClesVisiteur = array_keys($lesVisiteurs);
    $VisiteurSelectionner = $lesClesVisiteur[0]; //selection par defaut
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
