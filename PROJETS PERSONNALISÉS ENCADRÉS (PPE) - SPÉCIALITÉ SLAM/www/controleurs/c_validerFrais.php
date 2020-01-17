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
    //récuperation des réponse formulaire
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    
    //récuperation des mois disponible celon le visiteur selectionné
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi);
    $lesVisiteurs = $pdo->getVisiteurs(); // je recherche les visiteurs disponible pour les réafficher
    $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi); // avec l'id du visiteur choisi, je le recherche dans la bdd
    
    //test erreur $leMois
    $listeMoisString = array();
    if(count($lesMois)<=0){
        $leMois = null; // si aucun mois n'est disponible pour le visiteur, alors le mois récuperer est érroné et ne doit plus être celui qu'il est
    } else{
        // si le visiteur selectionné a au moins une fiche/ un mois
        foreach ($lesMois as $Mois){
            array_push($listeMoisString,$Mois['mois']); // construction d'un tableau 1D des mois 
        }
    }
    
    //correction $leMois
    if(count($lesMois)> 0 && (!in_array($leMois,$listeMoisString) || $leMois==null)){ // si le mois returné par le formulaire n'est pas dans la liste ou bien est null
        $lesCles = array_keys($lesMois);
        $leMois = $lesMois[$lesCles[0]]['mois']; // alors je prend le premier mois de la liste du visiteur selectionné
    }
    
    $moisSelectionner = $leMois;
    $visiteurSelectionner = $leVisiteur;
    include 'vues/v_listeVisiteur.php';
    
    //partie fiche Frais
    //declaration variable à null
    $lesFraisHorsForfait = null;
    $lesFraisForfait = null;
    $lesInfosFicheFrais = null;
    //Si il y a bien un mois selectionné
    if($moisSelectionner!=null){
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurChoisi, $moisSelectionner);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurChoisi, $moisSelectionner);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurChoisi, $moisSelectionner);
    $numAnnee = substr($moisSelectionner, 0, 4);
    $numMois = substr($moisSelectionner, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    }
    include 'vues/v_listeFraisForfait.php';
    include 'vues/v_listeFraisHorsForfait.php';
    include 'vues/v_valideFicheFrais.php';
//     var_dump($idVisiteurChoisi);
//     var_dump($leVisiteur['id']);
//     var_dump($leMois);
//     var_dump($lesMois);
//     var_dump($moisSelectionner);
//     var_dump($listeMoisString);
//     var_dump($lesFraisForfait);
//     var_dump($lesFraisHorsForfait);
    break;
case 'corrigerFraisForfait':
    // récuperation de l'id,mois,frais du formulaire reçu
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteurChoisi, $leMois, $lesFrais);
        //réaffichage page defaut
        $lesVisiteurs = $pdo->getVisiteurs();
        $leVisiteur = $pdo->getVisiteur($idVisiteurChoisi);
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteurChoisi);
        
        //test erreur $leMois
        $listeMoisString = array();
        if(count($lesMois)<=0){
            $leMois = null; // si aucun mois n'est disponible pour le visiteur, alors le mois récuperer est érroné et ne doit plus être celui qu'il est
        } else{
            // si le visiteur selectionné a au moins une fiche/ un mois
            foreach ($lesMois as $Mois){
                array_push($listeMoisString,$Mois['mois']); // construction d'un tableau 1D des mois
            }
        }
        
        //correction $leMois
        if(count($lesMois)> 0 && (!in_array($leMois,$listeMoisString) || $leMois==null)){ // si le mois returné par le formulaire n'est pas dans la liste ou bien est null
            $lesCles = array_keys($lesMois);
            $leMois = $lesMois[$lesCles[0]]['mois']; // alors je prend le premier mois de la liste du visiteur selectionné
        }
        
        $moisSelectionner = $leMois;
        $visiteurSelectionner = $leVisiteur;
        include 'vues/v_listeVisiteur.php';
        
        //partie fiche Frais
        //declaration variable à null
        $lesFraisHorsForfait = null;
        $lesFraisForfait = null;
        $lesInfosFicheFrais = null;
        //Si il y a bien un mois selectionné
        if($moisSelectionner!=null){
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurChoisi, $moisSelectionner);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurChoisi, $moisSelectionner);
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurChoisi, $moisSelectionner);
            $numAnnee = substr($moisSelectionner, 0, 4);
            $numMois = substr($moisSelectionner, 4, 2);
            $libEtat = $lesInfosFicheFrais['libEtat'];
            $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
            include 'vues/v_listeFraisForfait.php';
            include 'vues/v_listeFraisHorsForfait.php';
            include 'vues/v_valideFicheFrais.php';
        }
    
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
    include 'vues/v_valideFicheFrais.php';
    break;
case 'validerFicheFrais' :
    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    //passe la fiche à l'état validée
    //maj date modification
    $pdo->majEtatFicheFrais($idVisiteurChoisi, $leMois, 'VA');
    
    //redirection
    
    //Visiteurs
    $lesVisiteurs = $pdo->getVisiteurs(); // je prend la liste de tout les visiteurs existant
    $visiteurSelectionner = $lesVisiteurs[0]; //selection par defaut
    //Mois
    $lesMois = $pdo->getLesMoisDisponibles($visiteurSelectionner['id']);
    $lesCles = array_keys($lesMois);
    $moisSelectionner = $lesCles[0];
    include 'vues/v_listeVisiteur.php';
    break;
case 'reporterFraisHorsForfait' :

    $idVisiteurChoisi = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $idFraisHorsForfait = filter_input(INPUT_POST, 'idFraisHF', FILTER_SANITIZE_STRING);

    var_dump($idVisiteurChoisi);
    var_dump($leMois);
    var_dump($idFraisHorsForfait);
 
    //obtention mois prochain
    $moisProchain = null;$anneeProchaine = null;
    $mois = substr($leMois,-2);$annee = substr($leMois,0,4);
    
    if($mois=="12"){
        $moisProchain = "01";
        $anneeProchaine = $annee + 1;
    } else {
        $moisProchain = $mois + 1;
        $anneeProchaine = $annee;
    }
    //remise en forme mois ou année
    for($zeroDispaMois = 2 - strlen($moisProchain);$zeroDispaMois>0;$zeroDispaMois--)$moisProchain = "0" . $moisProchain;
    for($zeroDispaAnnee = 4 - strlen($anneeProchaine);$zeroDispaAnnee>0;$zeroDispaAnnee--)$anneeProchaine = "0" . $anneeProchaine;
    
    $resultat = $anneeProchaine . $moisProchain; // voici le mois prochain
    
    var_dump($resultat);
    
    $ficheFraisProchaine = $pdo->getLesInfosFicheFrais($idVisiteurChoisi,$resultat);
    
    //si la fiche de mois n'existe pas
    if($ficheFraisProchaine == false){
        $pdo->creeNouvellesLignesFrais($idVisiteurChoisi,$resultat); // je créé une fiche
        $ficheFraisProchaine = $pdo->getLesInfosFicheFrais($idVisiteurChoisi,$resultat);
    }
    
    //je récupère le info fraisHF
    $copie = null;
    foreach($pdo->getLesFraisHorsForfait($idVisiteurChoisi,$leMois) as $ligneFraisHF){
        if($ligneFraisHF['id']==$idFraisHorsForfait){
            $copie =  $ligneFraisHF;
        }
    }
    
    // je rajoute la ligne de fraisHorsForfait à cette fiche
    $pdo->creeNouveauFraisHorsForfait($idVisiteurChoisi,$resultat,$copie['libelle'],$copie['date'],$copie['montant']);
    
    // je supprime l'ancient frais HF
    $pdo->supprimerFraisHorsForfait($idFraisHorsForfait);
    
    
    break;
}
?>
