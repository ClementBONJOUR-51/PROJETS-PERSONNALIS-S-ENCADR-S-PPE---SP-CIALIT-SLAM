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
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING); //récuperation des réponse formulaire
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi); // je recherche les mois disponible avec le visiteur choisi
    if($leMois==null && count($lesMois)>0){ //debug : si il n'y avais aucun mois auparavant, alors je prend le premier mois du visiteur selectionner si il y en a un !
        $leMois = $lesMois[0]['mois'];
    }
    $lesVisiteurs = $pdo->getVisiteurs(); // je recherche les visiteurs disponible pour les réafficher 
    $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi); // avec l'id du visiteur choisi, je le recherche dans la bdd
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
    // récuperation de l'id,mois,frais du formulaire reçu et execution de le requête
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        /*var_dump($leVisiteur);
        var_dump($leMois);
        var_dump($lesFrais);*/
        $pdo->majFraisForfait($idVisiteurChoisi, $leMois, $lesFrais);
        //réaffichage page defaut
        $lesVisiteurs = $pdo->getVisiteurs();
        $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi);
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi);
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
    
    } else {
        ajouterErreur('Les valeurs des frais doivent Ãªtre numÃ©riques');
        include 'vues/v_erreurs.php';
    }
    break;
case 'corrigerFraisHorsForfait':
    //récuperation des réponses corrigées du formulaire
    $idFraisHorsForfait = filter_input(INPUT_POST, 'idFraisHF', FILTER_SANITIZE_STRING);
    $dateFraisHorsForfait = filter_input(INPUT_POST, 'dateHF', FILTER_SANITIZE_STRING);
    $libFraisHorsForfait = filter_input(INPUT_POST, 'libHF', FILTER_SANITIZE_STRING);
    $libFraisHorsForfait = substr($libFraisHorsForfait,0,99); // je tronque si la taille du lib et plus grand que 100
    $montantFraisHorsForfait = filter_input(INPUT_POST, 'montantHF', FILTER_SANITIZE_STRING);
    $fraisHorsForfait = array(
    'libelle' => $libFraisHorsForfait,
    'date' => $dateFraisHorsForfait,
    'montant' => $montantFraisHorsForfait     
    );
    /*var_dump($idFraisHorsForfait);
    var_dump($fraisHorsForfait['libelle']);
    var_dump($fraisHorsForfait['date']);
    var_dump($fraisHorsForfait['montant']);*/
    valideInfosFrais($dateFraisHorsForfait, $libFraisHorsForfait, $montantFraisHorsForfait);
    if (nbErreurs() != 0) { // si il n'y a pas d'erreur dans la date et autre
        include 'vues/v_erreurs.php';
    } else {
        $pdo->majFraisHorsForfait($idFraisHorsForfait, $fraisHorsForfait);
    }
    
    
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $lesVisiteurs = $pdo->getVisiteurs();
    $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi);
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi);
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
}
?>
