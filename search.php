<?php

include('include/connexion.php');
require_once 'Entity/Personne.php';

// var_dump($_GET['name']);

if(isset($_GET['name'])) {

    // $results = [];
    $input = $_GET['name'];

    $stmt = $bdd->prepare("SELECT * FROM cnrs.table_lien_bms 
    WHERE Fonction IN ('père','mère','Role_Principal')
    AND  id_événement IN
        (
            SELECT id_événement FROM cnrs.bms WHERE Type_evt = 'Baptême'
        )
    AND id_individu IN
    (
        SELECT id_individu FROM cnrs.table_lien_bms WHERE id_événement IN
            (
                SELECT id_événement FROM cnrs.bms WHERE Type_evt = 'Baptême'
            )
        AND Fonction IN ('père','mère') AND id_individu IN 
            (
                SELECT id_individu FROM cnrs.table_lien_bms WHERE id_événement IN
                    (
                        SELECT id_événement FROM cnrs.bms WHERE Type_evt = 'Baptême'
                    )
                AND Fonction = 'Role_Principal'
            )
    ) 
    AND nom LIKE '%$input%' ");




    // $sql =   "SELECT * FROM recensement_population WHERE nom LIKE '%$input%' LIMIT 100";
    // $sql =   "SELECT * FROM recensement_population WHERE nom LIKE '%:input%' LIMIT 100";
    // $stmt = $bdd->prepare($sql);
    $stmt->execute();
    // $stmt->execute(array(
    //     ':input' => $_GET['name']
    // ));

    // var_dump($stmt);

    // $rows = $rows->fetchAll();
    
    $results = [];

    while ( $p = $stmt->fetch() ) {
    
        // var_dump($p);

        // $tmpPersonne = new Personne();
    
        // $tmpPersonne = new Personne(
        $results[] = new Personne(
            isset($p['id_individu'])    ?   $p['id_individu']   :   NULL, //$id, 
            isset($p['Nom'])    ?   $p['Nom']   :   NULL, //$nom, 
            isset($p['quartier'])    ?   $p['quartier']   :   NULL, //$quartier, 
            isset($p['Sexe'])    ?   $p['Sexe']   :   NULL, //$sexe, 
            isset($p['fonction_menage'])    ?   $p['fonction_menage']   :   NULL, //$fonction_menage,
            // "fdp3000", //$fonction_menage,
            isset($p['profession'])    ?   $p['profession']   :   NULL, //$profession, 
            isset($p['lieu_naissance'])    ?   $p['lieu_naissance']   :   NULL, // $lieu_naissance
        );
        // var_dump($tmpPersonne);
        // echo json_encode($tmpPersonne, JSON_FORCE_OBJECT);
    }
    // var_dump($results);
    
    echo json_encode($results);

}








?>