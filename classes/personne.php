<?php
abstract class Personne{
	protected $_id; // identifiant unique d'une personne
	protected $_nom;
	protected $_prenom;
	protected $_adresse;
	protected $_age;

	protected function __construct($id, $nom, $prenom, $adresse, $age){
		$this->_id = $id;
		$this->_nom = $nom;
		$this->_prenom = $prenom;
		$this->_adresse = $adresse;
		$this->_age = $age;
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

// Autres
	public function __toString(){
		return $this->get('_prenom')." ".$this->get('_nom')." (".get_class($this)." ".$this->get('_id').")<br/>";
	}
} 

class Etudiant extends Personne{
	private $_coefFam; // coefficient familial
	private $_fraisInscr; // frais d'inscription, dépendant du coefficient familial
	private $_ville; // ville à laquelle est rattaché l'étudiant
	private $_ufr; // Cursus dans lequel est inscrit l'étudiant

	public function __construct($id, $nom, $prenom, $adresse, $age, $cf, $ville, $ufr){
		parent::__construct($id, $nom, $prenom, $adresse, $age);
		$this->_coefFam = $cf;
		$this->_fraisInscr = calculFrais($cf);
		$this->_ville = $ville;
		$this->_ufr = $ufr;
	}
	public function calculFrais($cf){

		return $f;
	}
}

class Professeur extends Personne{
	private $_salaire;
	private $_ufr; // Cursus auquel le professeur est rattaché 
	private $_ville; // ville à laquelle est rattaché le professeur
	private $_arrCours; // liste de cours qu'enseigne le professeur
	private $_arrVilles; // liste de villes où enseigne le professeur
	
	public function __construct($id, $nom, $prenom, $adresse, $age, $sal, $ufr, $ville){
		parent::__construct($id, $nom, $prenom, $adresse, $age);
		$this->_salaire = $sal;
		$this->_ufr = $ufr;
		$this->_ville = $ville;
		$this->_arrCours = defCours($this->_ufr);
		$this->_arrVille = defVilles();
	}
	
	private defCours($ufr){

	}

	private defVilles(){

	}
}

?>