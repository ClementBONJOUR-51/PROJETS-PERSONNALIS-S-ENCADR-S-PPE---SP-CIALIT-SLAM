<?php 
/**
 * VALIDATION D’UNE FICHE DE FRAIS
 */



$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case 'selectionnerVisiteurEtMois':
    //Visiteurs
    $lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
    $visiteurSelectionner = $lesVisiteurs[0]; //selection par defaut
    //Mois
    $lesMois = $pdo->getLesMoisDisponibles($visiteurSelectionner['id']);
    $lesCles = array_keys($lesMois);
    $moisSelectionner = $lesCles[0];
    include 'vues/v_listeVisiteur.php';
    break;
case 'resultatFicheFrais':
    $idVisiteurChoisi = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesVisiteurs = $pdo->getVisiteurs();
    $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi);
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi);
    //var_dump($leMois);
    //var_dump($leVisiteur);
    $visiteurSelectionner = $leVisiteur;
    $moisSelectionner = $leMois;
    include 'vues/v_listeVisiteur.php';
    break;
}
?>
