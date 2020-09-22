<?php

// namespace Repository;

// use Entity\Personne;

class PersonneRepository
{

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function findAll() {

        $results = [];

        $sql =   'SELECT * FROM recensement_population LIMIT 100';
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        // $rows = $rows->fetchAll();

        while ( $p = $stmt->fetch() ) {

            // $tmpPersonne = new Personne();

            $results[] = new Personne(
                isset($p['id_individu'])    ?   $p['id_individu']   :   NULL, //$id, 
                isset($p['nom'])    ?   $p['nom']   :   NULL, //$nom, 
                isset($p['quartier'])    ?   $p['quartier']   :   NULL, //$quartier, 
                isset($p['sexe'])    ?   $p['sexe']   :   NULL, //$sexe, 
                isset($p['fonction_menage'])    ?   $p['fonction_menage']   :   NULL, //$fonction_menage,
                // "fdp3000", //$fonction_menage,
                isset($p['profession'])    ?   $p['profession']   :   NULL, //$profession, 
                isset($p['lieu_naissance'])    ?   $p['lieu_naissance']   :   NULL, // $lieu_naissance
            );
        }

        return $results;
        
    }


}

        

?>