<?php
class Personne{
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

	private function calculFrais($cf){
		// les frais de scolarité se calculent sur la base du coefficient familial
		// un $cf non-numérique donnera des frais de scolarité égaux à -1
		if (is_numeric($cf)){
			if($cf <= 12620) 	return 0.00;
			if($cf <= 13190) 	return 100.00;
			if($cf <= 15640) 	return 125.50;
			if($cf <= 24740) 	return 189.00;
			if($cf <= 31810) 	return 233.25;
			if($cf <= 39970)	return 275.60;
			if($cf <= 48360) 	return 432.15;
			if($cf <= 55790) 	return 560.40;
			if($cf <= 92970) 	return 789.60;
			if($cf <= 127860) 	return 1325.00;
			if($cf <= 151250) 	return 1698.50;
			if($cf <= 172040) 	return 2796.00;
			if($cf <= 195000) 	return 3845.90;
			else 				return 12589.00;
		}
		else return -1;
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
		$villes = array();
		$nb_villes = rand(1, 3); // on tire au hasard un nombre de villes dans lesquelles le professeur va enseigner
		switch ($nb_villes) {
			case 1:
				$villes[0] = 'Nantes';
				break;
			case 2:
				$villes[0] = 'Nantes';
				$villes[1] = 'Saint-Nazaire';
				break;
			case 3:
				$villes[0] = 'Nantes';
				$villes[1] = 'Saint-Nazaire';
				$villes[2] = 'Rennes';
				break;
		}
		return $villes;
	}
}

?>