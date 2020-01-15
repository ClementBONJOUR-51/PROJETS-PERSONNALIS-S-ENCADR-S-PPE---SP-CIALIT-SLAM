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
    $idVisiteurChoisi = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING); //récuperation des réponse formulaire
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesVisiteurs = $pdo->getVisiteurs(); // je recherche les visiteurs disponible pour les réafficher 
    $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi); // avec l'id du visiteur choisi, je le recherche dans la bdd
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi); // je recherche les mois disponible avec le visiteur choisi
    /*var_dump($leMois);
    var_dump($idVisiteurChoisi);
    var_dump($lesMois);
    var_dump($leVisiteur['id']);*/
    $visiteurSelectionner = $leVisiteur;
    $moisSelectionner = $leMois;
    include 'vues/v_listeVisiteur.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurChoisi, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurChoisi, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurChoisi, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_listeFraisForfait.php';
    include 'vues/v_listeFraisHorsForfait.php';
    break;
case 'corrigerFraisForfait':
    $idVisiteurChoisi = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING); //récuperation des réponse formulaire
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        var_dump($idVisiteurChoisi);
        var_dump($leMois);
        var_dump($lesFrais);
        $debug = $pdo->majFraisForfait($idVisiteurChoisi, $leMois, $lesFrais);
    } else {
        ajouterErreur('Les valeurs des frais doivent Ãªtre numÃ©riques');
        include 'vues/v_erreurs.php';
    }
    break;
}
?>
