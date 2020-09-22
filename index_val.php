<?php

require_once('include/connexion.php');
require_once('Entity/Personne.php');

$test = $bdd->prepare("SELECT * FROM cnrs.table_lien_bms 
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
                        )");
$test->execute();

$tmp = [];

while($data = $test->fetch()) {
    $personne = new Personne($data['id_individu'], $data['Nom'], null, null, null, null, null);
    array_push($tmp, $personne);
}

var_dump($tmp);

$test->closeCursor();

$tmp2 = [];

// foreach($tmp as $personne) {
    // $id = $personne->getId();
    $id = 9242;
    $infos = $bdd->prepare("SELECT * FROM recensement_population WHERE id_individu = :id LIMIT 1" ) ;
    $infos->execute(array('id' => $_GET['idPersonne']));

    while($data = $infos->fetch()) {
        $personne = new Personne($data['id_individu'], $data['nom'], $data['quartier'], $data['Sexe'], $data['fonction_menage'], $data['profession'], $data['lieu_de_naissance']);
        array_push($tmp2, $personne);
    }
    $infos->closeCursor();
// }

foreach($tmp2 as $personne) {
    // echo $personne->getId();
    // echo "<br>";
    var_dump($personne);
}

?>