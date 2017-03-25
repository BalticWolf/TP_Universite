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

	protected function getInfoFromFile($fname, $id){ // permet de renvoyer des infos d'une personne grâce à son ID, sous forme d'un tableau
		$personne = array();
		$fp = fopen($fname, 'r');
		while(!feof($fp)){
			$current = fgets($fp, 511);
			if(substr_count($current, ';') >= 6){
				$item = explode(';', $current);
				if($item[0] == $id){
					$personne = $item;
					break;
				}
			}
		}
		fclose($fp);
		return $personne;
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	public function __toString(){
		return $this->get('_prenom')." ".$this->get('_nom')." (".get_class($this)." ".$this->get('_id').")<br/>";
	}
} 

class Etudiant extends Personne{
	private $_coefFam; 			// coefficient familial
	private $_fraisInscr; 		// frais d'inscription, dépendant du coefficient familial
	private $_ville; 			// ville à laquelle est rattaché l'étudiant
	private $_ufr; 				// Cursus dans lequel est inscrit l'étudiant
	private $_arrLivres; 		// liste des livres empruntés par l'étudiant

	public function __construct($id, $nom, $prenom, $adresse, $ville, $age, $cf, $ufr){
		$etud = parent::getInfoFromFile('data/etudiants.csv', $id);
		parent::__construct($etud[0], $etud[1], $etud[2], $etud[3], $etud[5]);
		$this->_coefFam = $etud[6];
		$this->_fraisInscr = calculFrais($cf);
		$this->_ville = $etud[4];
		$this->_ufr = $etud[7];
		$this->_arrLivres = array();
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
	
	public function __construct($id){
		$prof = parent::getInfoFromFile('data/professeurs.csv', $id);
		parent::__construct($prof[0], $prof[1], $prof[2], $prof[3], $prof[4]); // $id, $nom, $prenom, $adresse, $age
		$this->_salaire = $prof[5];
		$this->_ville = $prof[6];
		$this->_ufr = $prof[7];
		$this->_arrCours = defCours($this->_ufr);
		$this->_arrVille = defVilles();
	}

	private defCours($ufr){		// permet de définir la liste des cours que le prof est censé enseigner
		$coursProf = array();					// constitue l'ensemble des cours que le prof va enseigner

		$nb_coursUFR = count($coursUFR);
		$nb_cours_prof = rand(1, $nb_coursUFR); 					// on choisit arbitrairement un nombre de matières que le prof enseigne
		while(count($coursProf) < $nb_cours_prof){					// tant qu'on n'a pas attribué le nb correct de cours au prof
			$coursHasard = $coursUFR[rand(0, $nb_cours_prof - 1)]; 	// on pioche un cours de l'UFR au hasard
			if(!in_array($coursHasard, $coursProf)){ 				// si le cours ne fait pas déjà partie des cours enseignés par le prof
				$coursProf[] = $coursHasard; 						// on l'ajoute
			}
		}

		return $coursProf;
	}

	private defVilles(){		// permet de définir une liste de villes dans lesquelles le professeur va enseigner
		$villes = array();
		$nb_villes = rand(2, 3); // on tire au hasard un nombre de villes
		
		$villes[0] = 'Nantes'; // par défaut, il enseigne à Nantes.
		switch ($nb_villes) {
			case 2:
				$villes[1] = 'Saint-Nazaire'; // et à St Nazaire s'il enseigne dans 2 villes,
				break;
			case 3:
				$villes[1] = 'Saint-Nazaire';
				$villes[2] = 'Rennes';			// ou dans les 3 villes
				break;
		}
		return $villes;
	}
}

?>