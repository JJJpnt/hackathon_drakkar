<?php

// namespace Entity;

class Personne {
    
    public $_id;
    public $_nom;
    public $_quartier;
    public $_sexe;
    public $_fonction_menage;
    public $_profession;
    public $_lieu_naissance;

    public function __construct($id, $nom, $quartier, $sexe, $fonction_menage, $profession, $lieu_naissance) {
        $this->_id = $id;
        $this->_nom = $nom;
        $this->_quartier = $quartier;
        $this->_sexe = $sexe;
        $this->_fonction_menage = $fonction_menage;
        $this->_profession = $profession;
        $this->_lieu_naissance = $lieu_naissance;
    }

    public function getId() {
        return $this->_id;
    }

    public function getNom() {
        return $this->_nom;
    }

    public function getQuartier() {
        return $this->_quartier;
    }

    public function getSexe() {
        return $this->_sexe;
    }

    public function getFonctionMenage() {
        return $this->_fonction_menage;
    }

    public function getProfession() {
        return $this->_profession;
    }

    public function getLieuNaissance() {
        return $this->_lieu_naissance;
    }
}

?>