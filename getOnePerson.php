<?php

include('include/connexion.php');
require_once 'Entity/Personne.php';

// var_dump($_GET['name']);

if(isset($_GET['idPersonne'])) {

    // $results = [];
    $input = $_GET['idPersonne'];

    $infos = $bdd->prepare("SELECT * FROM recensement_population WHERE id_individu = :id" ) ;
    $infos->execute(array('id' => $_GET['idPersonne']));

    while($data = $infos->fetch()) {
        $personne = new Personne(
            isset($data['id_individu'])    ?   $data['id_individu']   :   NULL, //$id, 
            isset($data['nom'])    ?   $data['nom']   :   NULL, //$nom, 
            isset($data['quartier'])    ?   $data['quartier']   :   NULL, //$quartier, 
            isset($data['Sexe'])    ?   $data['Sexe']   :   NULL, //$sexe, 
            isset($data['fonction_menage'])    ?   $data['fonction_menage']   :   NULL, //$fonction_menage,
            // "fdp3000", //$fonction_menage,
            isset($data['profession'])    ?   $data['profession']   :   NULL, //$datarofession, 
            isset($data['lieu_de_naissance'])    ?   $data['lieu_de_naissance']   :   NULL, // $lieu_naissance
        );
    }
    $infos->closeCursor();
// }

    // $results = [];

        // var_dump($tmpPersonne);
        // echo json_encode($tmpPersonne, JSON_FORCE_OBJECT);
    
    // var_dump($results);
    
    echo json_encode($personne);

}








?>