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
	public function __construct($id, $nom, $prenom, $adresse, $age){
		parent::__construct($id, $nom, $prenom, $adresse, $age)
	}
}

class Professeur extends Personne{
	private $_salaire;
	private $_UFR; // Cursus auquel le professeur est rattaché. 
	
	public function __construct($id, $nom, $prenom, $adresse, $age){
		parent::__construct($id, $nom, $prenom, $adresse, $age); // appel au constructeur parent
	}

}

?>