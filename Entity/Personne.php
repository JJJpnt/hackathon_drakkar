<?php

class Personne {
    
    private $_id;
    private $_nom;
    private $_quartier;
    private $_sexe;
    private $_fonction_menage;
    private $_profession;
    private $_lieu_naissance;

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

    public function setId($x) {
        $this->_id = $x;
    }

    public function setNom($x) {
        $this->_nom = $x;
    }

    public function setQuartier($x) {
        $this->_quartier = $x;
    }

    public function setSexe($x) {
        $this->_sexe = $x;
    }

    public function setFonctionMenage($x) {
        $this->_fonction_menage = $x;
    }

    public function setProfession($x) {
        $this->_profession = $x;
    }

    public function setLieuNaissance($x) {
        $this->_lieu_naissance = $x;
    }
}

?>