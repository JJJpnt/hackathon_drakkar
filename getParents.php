<?php

include('include/connexion.php');
require_once 'Entity/Personne.php';

// var_dump($_GET['name']);

// if(isset($_GET['name'])) {

    // $results = [];
    // $input = 32277;
    $input = 32276;

    $stmt = $bdd->prepare(
    "SELECT * FROM cnrs.table_lien_bms 
    AND Fonction IN ('mère', 'père')
    WHERE id_individu = '$input'
    AND Fonction IN ('mère', 'père')
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

    var_dump($evts);

    foreach($evts as $idEvt) {
        
        $sql_children = "   SELECT * FROM recensement_population r
                            INNER JOIN
                                    (SELECT * FROM table_lien_bms       
                                    WHERE id_événement = :idEvt
                                    AND Fonction = 'Role_Principal') AS l
                                    ON r.id_individu = l.id_individu
        ";
    
        $stmt_children = $bdd->prepare($sql_children);
    
        $stmt->execute(array(
            ':idEvt' => $idEvt
        ));

        
    }


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

// }








?>