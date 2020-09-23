<?php

include('include/connexion.php');
require_once 'Entity/Personne.php';

// var_dump($_GET['name']);

if(isset($_GET['idPerson'])) {

    // $results = [];
    // $input = 32277;
    $input = $_GET['idPerson'];

    $stmt = $bdd->prepare(
    "SELECT * FROM cnrs.table_lien_bms 
    WHERE id_individu = '$input'
    AND Fonction = 'Role_Principal'
    AND id_événement IN
        (
            SELECT id_événement FROM cnrs.bms WHERE Type_evt = 'Baptême'
        )
    ");

    $evts = [];

    $stmt->execute();

    while ( $p = $stmt->fetch() ) {
    
        $evts[] = $p['id_événement'];
    }

    $results = [];

    foreach($evts as $idEvt) {
        
        $sql_parents = "SELECT * FROM table_lien_bms       
                        WHERE id_événement = :idEvt
                        AND Fonction IN ('mère', 'père')
        ";
    
        $stmt_parents = $bdd->prepare($sql_parents);
    
        $stmt_parents->execute(array(
            ':idEvt' => $idEvt
        ));


        
        while ( $p = $stmt_parents->fetch() ) {
    
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

    }


    // var_dump($stmt);

    // $rows = $rows->fetchAll();
    



    // var_dump($results);
    
    echo json_encode($results);

// }








?>